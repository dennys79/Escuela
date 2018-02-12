<?php

/**
 * Comprueba que tenemos un directorio del controlador predeterminado. Si no, una
 * Excepción es lanzada.
 */
class App_Bootstrap
{

    protected $_request;
    protected $_controller;
    protected $_rutaControlador;
    protected $_rutaBaseModulo;
    protected $_modulo;

    /**
     * Inicializacion del bootstrap
     * @param App_Request $request
     */
    public function __construct(App_Request $request)
    {
        $this->_request = $request;
    }

    /**
     * Ejecuta la App
     * @throws Exception 
     */
    public function run()
    {
        $session = App_Session::init();
        $this->_modulo = $this->_request->getModulo();
//        echo 'el modulo es: ' . $this->_modulo . '<br>';
        $this->_controller = $this->_request->getControlador() . 'Controlador';
//        echo 'el controlador es: ' . $this->_controller . '<br>';
        $metodo = $this->_request->getMetodo();
//        echo 'el metodo es: ' . $metodo . '<br>';
        $args = $this->_request->getArgumentos();
//        echo 'el argumento es: ' . $args . '<br>';
        /* Control y carga del módulo */
        $this->_controlModulo($this->_modulo);
        $this->_controlControlador();
        $this->_controlMetodo($metodo, $args);
    }

    /**
     * Verifica que el módulo exista y establece la ruta del controlador
     * @param string $modulo
     * @throws Exception
     */
    private function _controlModulo($modulo)
    {
        if ($modulo) {
            $this->_rutaBaseModulo = MODS_PATH . ucfirst($modulo);
//            echo 'Base Modulo: '.$this->_rutaBaseModulo.'<br>';
            if (!is_readable($this->_rutaBaseModulo)) {
                throw new Exception('No se puede localizar el módulo ' . $modulo);
            }
            if (!$this->_ifModuloHabilitado($modulo)){
                throw new Exception('El módulo ' . $modulo . ' no está habilitado');
            }
        } else{
            $this->_rutaBaseModulo = BASE_PATH . 'Controladores' . DS;
//            echo $this->_rutaBaseModulo.'<br>';
        }
    }

    /**
     * Verifica que exista y crea el objeto controlador
     * @param string $modulo
     * @throws Exception
     */
    private function _controlControlador()
    {
        if($this->_modulo){
            $this->_rutaControlador = $this->_rutaBaseModulo . DS . 'Controladores'
                . DS . ucfirst($this->_controller) . '.php';
            $controlador = $this->_modulo . '_Controladores_' . ucfirst($this->_controller);
        }  else {
            $this->_rutaControlador = BASE_PATH . 'Controladores'
                . DS . ucfirst($this->_controller) . '.php';
            $controlador = 'Controladores_' . ucfirst($this->_controller);
        }
//        echo 'Ruta Controlador: '.$this->_rutaControlador.'<br>';
        if (is_readable($this->_rutaControlador)) {
            require_once $this->_rutaControlador;
//            $controlador = $this->_modulo . '_Controladores_' . $this->_controller;
//            echo $controlador;
            $this->_controller = new $controlador;
        } else {
            throw new Exception($this->_controller . ' No encontrado');
        }
    }

    /**
     * Verifica y llama al método del controlador
     * @param string $metodo
     * @param array $args
     */
    private function _controlMetodo($metodo, $args)
    {
        if (is_callable(array($this->_controller, $metodo))) {
            if (isset($args)) {
                call_user_func_array(array($this->_controller, $metodo), $args);
            } else {
                call_user_func(array($this->_controller,$metodo));
            }
        }
    }
    
    private function _ifModuloHabilitado($modulo)
    {
        require_once MODS_PATH . 'Administrator' . DS . 'Controladores' . DS . 'ModulosControlador.php';
        $retorno = FALSE;
        $modulos = new Administrador_ModulosControlador();
        $modulosHabilitados = $modulos->getModulosHabilitados();
        if (count($modulosHabilitados)) {
            foreach ($modulosHabilitados as $mod) {
                if ($mod == $modulo) {
                    $retorno = TRUE;
                } 
            }
        } 
        return $retorno;
    }

}
