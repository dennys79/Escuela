<?php

/**
 * Controlador principal del sitio
 */
require_once (BASE_PATH . 'LibQ' . DS . 'ArchivosYcarpetas.php');
require_once LIB_PATH . 'BarraHerramientas.php';
require_once BASE_PATH . 'Modelos' . DS . 'IndexModelo.php';
require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once MODS_PATH . 'Personal' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once MODS_PATH . 'Ciclo' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once MODS_PATH . 'Usuarios' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once MODS_PATH . 'Cursos' . DS . 'Modelos' . DS . 'IndexModelo.php';

//require_once LIB_PATH . 'jpgraph' . DS . 'src' . DS . 'jpgraph.php';
//require_once LIB_PATH . 'jpgraph' . DS . 'src' . DS . 'jpgraph_bar.php';

class Controladores_IndexControlador extends App_Controlador
{

    protected $_modelo;
    protected $_alumno;
    protected $_personal;
    protected $_ciclo;
    protected $_usuario;
    protected $_curso;

    public function __construct()
    {
        parent::__construct();
        $this->_modelo = new Modelos_IndexModelo();
        $this->_alumno = new Alumno_Modelos_indexModelo();
        $this->_personal = new Personal_Modelos_IndexModelo();        
        $this->_ciclo = new Ciclo_Modelos_indexModelo();
        $this->_usuario = new Usuarios_Modelos_indexModelo();
        $this->_curso = new Cursos_Modelos_indexModelo();
    }

    public function index()
    {
        $this->_vista->alumnos = count($this->_alumno->getAlumnos());
        $this->_vista->personal = count($this->_personal->getTodoPersonal());
        $this->_vista->ciclo = $this->_ciclo->getCicloActual();
        $this->_vista->usuarios = count($this->_usuario->getUsuarios());
        $this->_vista->cursos = count($datos = $this->_curso->getCursos());
        $this->isAutenticado();
        $modulos = \LibQ_ArchivosYcarpetas::listar_directorios_ruta('Modulos/');
        $menu = $this->_crearMenuModulos($modulos);
        /** Barra de herramientas */
        $bh = new LibQ_BarraHerramientas();
        foreach ($menu as $key => $value) {
            $bh->addBoton('imagen', $value);
        }
        $this->_vista->_barraHerramientas_principal = $bh->render();
        /* Me fijo si hay modulos para cargar */
        if (is_array($this->_getModulosVista())) {
            $this->_vista->modulos = $this->_getModulosVista();
        }
//        $this->_vista->estadisticas = $this->_datosEstadistica();
        $this->_vista->titulo = APP_NAME;
        $this->_vista->renderizar('Index');
    }

    /**
     * Creacion y muestra de modulos de vista
     */
    private function _getModulosVista()
    {
        $sec_modulos = false;
//        $path = BASE_PATH . 'Modulos' . DS;
//        $sec_modulos = array(
//            $path . 'Compras' . DS . 'Vistas' . DS . 'Index' . DS . 'UltimasCompras.phtml',
//            $path . 'Ventas' . DS . 'Vistas' . DS . 'Index' . DS . 'UltimasVentas.phtml',
//            $path . 'Honorarios' . DS . 'Vistas' . DS . 'Index' . DS . 'UltimosHonorarios.phtml',
//            $path . 'Sueldos' . DS . 'Vistas' . DS . 'Index' . DS . 'UltimosSueldos.phtml',
//            'Vistas' . DS . 'Index' . DS . 'estadisticas.phtml',
//        );
        return $sec_modulos;
    }

    /**
     * Crea el menu de los modulos en forma de Array
     * @param Array $modulos
     * @return string
     */
    private function _crearMenuModulos($modulos)
    {
        foreach ($modulos as $modulo) {
            if ($this->_controlModuloVisible($modulo) 
                    && $this->_ifModuloHabilitado($modulo)
                    && $this->_ifModuloVisible($modulo)) {
                $menu[$modulo] = $this->_crearMenu($modulo);
            }
        }
        return $menu;
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
    
    /**
     * Se fija que el modulo sea visible
     * En caso que no sea visible si el usuario es admin lo muestra igual
     * @param string $modulo
     * @return boolean
     */
    private function _ifModuloVisible($modulo)
    {
        require_once MODS_PATH . 'Administrator' . DS . 'Controladores' . DS . 'ModulosControlador.php';
        $retorno = FALSE;
        $modulos = new Administrador_ModulosControlador();
        $modulosVisibles = $modulos->getModulosVisibles();
        if (count($modulosVisibles)) {
            foreach ($modulosVisibles as $mod) {
                if ($mod == $modulo || App_Session::get('level')==1) {
                    $retorno = TRUE;
                } 
            }
        } 
        return $retorno;
    }
    
//    private function _ifModuloAccesible($modulo)
//    {
//        require_once MODS_PATH . 'Administrator' . DS . 'Controladores' . DS . 'ModulosControlador.php';
//        $retorno = FALSE;
//        $modulos = new Administrador_ModulosControlador();
//        $modulosVisibles = $modulos->getModulosVisibles();
//        if (count($modulosVisibles)) {
//            foreach ($modulosVisibles as $mod) {
//                if ($mod == $modulo) {
//                    $retorno = TRUE;
//                } 
//            }
//        } 
//        return $retorno;
//    }

    private function _crearMenu($modulo)
    {
        $menu = array(
            'id' => strtolower($modulo),
            'titulo' => ucfirst($modulo),
            'href' => BASE_URL . '?mod=' . ucfirst($modulo),
            'icono' => 'Modulos/' . ucfirst($modulo) .
            '/Vistas/Mod_' . ucfirst($modulo) . '.png',
            'classIcono' => '',
            'class' => 'btn btn-primary'
        );
        return $menu;
    }

    /**
     * Controla que el modulo sea visible.
     * Un módulo es invisible cuando comienza con "_".
     * @param String $modulo
     * @return boolean
     */
    private function _controlModuloVisible($modulo)
    {
        $retorno = false;
        $caracter = substr($modulo, 0, 1);
        if ($caracter != "_") {
            $retorno = true;
        }
        return $retorno;
    }

    /**
     * Calcula estadisticas para mostrar en el index
     * @return string
     */
    private function _datosEstadistica()
    {
        $estadisticas['totalPacientes'] = $this->_modelo->getCantidadPacientes();
        $estadisticas['pacientesVarones'] = $this->_modelo->getCantidadPacientesVarones();
        $estadisticas['pacientesMujeres'] = $this->_modelo->getCantidadPacientesMujeres();
        $estadisticas['os'] = $this->_modelo->getCantidadPacientesXOS();
        return $estadisticas;
    }

}
