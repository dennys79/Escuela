<?php
require_once MODS_PATH . 'Personal' . DS . 'Modelos' . DS . 'DomicilioModelo.php';
require_once MODS_PATH . 'Personal' . DS . 'Modelos' . DS . 'Personal.php';

require_once LIB_PATH . 'ValidarFormulario.php';

/**
 * Clase Personal Controlador 
 */
class Personal_Controladores_domicilioControlador extends App_Controlador
{

    private $_personal;

    public function __construct()
    {
        parent::__construct();
        $this->_personal = new Personal_Modelos_domicilioModelo();
    }
    
    public function index()
    {
    }

    public function guardar()
    {
        $rtdo = '';
        $datos = $this->_limpiarDatos();
        $errores = $this->_validarPost($datos);
        $aGuardar = $this->_prepararDatosDomicilio($datos);
        if ($errores->getRetEval()) {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (isset($datos['id_domicilio']) && $datos['id_domicilio']!==NULL && $datos['id_domicilio']!=='') {
                echo 'Editando domicilio...';
                $rtdo = $this->_personal->editarDomicilio($aGuardar, 'id_domicilio=' . $aGuardar['id_domicilio']);
            } else {
                unset($aGuardar['id_domicilio']);
                echo 'Guardando nuevo domicilio...';
                $rtdo = $this->_personal->insertarDomicilio($aGuardar);
                var_dump($rtdo);
            }
            if ($rtdo) {
                $this->_vista->_mensaje = 'DATOS_GUARDADOS';
            } else {
                $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
            }
        }
        $this->redireccionar('mod=Personal&cont=index&met=editar&id='.$datos['id_personal']);
    }
    
    /**
     * Limpia los datos que vienen del Post
     * @return array $datos
     */
    private function _limpiarDatos()
    {
        $datos['guardar_domicilio'] = filter_input(INPUT_POST, 'guardar_domicilio', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_domicilio'] = filter_input(INPUT_POST, 'id_domicilio', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_personal'] = filter_input(INPUT_POST, 'id_personal', FILTER_SANITIZE_NUMBER_INT);
        $datos['calle'] = filter_input(INPUT_POST, 'calle', FILTER_SANITIZE_STRING);
        $datos['casa_nro'] = filter_input(INPUT_POST, 'casa_nro', FILTER_SANITIZE_STRING);
        $datos['piso'] = filter_input(INPUT_POST, 'piso', FILTER_SANITIZE_STRING);
        $datos['depto'] = filter_input(INPUT_POST, 'depto', FILTER_SANITIZE_STRING);
        $datos['barrio'] = filter_input(INPUT_POST, 'barrio', FILTER_SANITIZE_STRING);
        $datos['cp'] = filter_input(INPUT_POST, 'cp', FILTER_SANITIZE_STRING);
        $datos['localidad'] = filter_input(INPUT_POST, 'localidad', FILTER_SANITIZE_STRING);
        $datos['provincia'] = filter_input(INPUT_POST, 'provincia', FILTER_SANITIZE_STRING);
        $datos['pais'] = filter_input(INPUT_POST, 'pais', FILTER_SANITIZE_STRING);
        return $datos;
    }
    
    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos)
    {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['calle'], 'text', 'La denominación no es válida');
        return $validar;
    }
    
    private function _prepararDatosDomicilio()
    {
        $domicilio = array(
            'id_domicilio' => parent::getPostParam('id_domicilio'),
            'id_personal' => parent::getPostParam('id_personal'),
            'calle' => parent::getPostParam('calle'),
            'casa_nro' => parent::getPostParam('casa_nro'),
            'piso' => parent::getPostParam('piso'),
            'depto' => parent::getPostParam('depto'),
            'barrio' => parent::getPostParam('barrio'),
            'cp' => parent::getPostParam('cp'),
            'localidad' => parent::getPostParam('localidad'),
            'provincia' => parent::getPostParam('provincia'),
            'pais' => parent::getPostParam('pais'),
        );
        return $domicilio;
    }
    
    private function _nuevoDomicilio()
    {
    }
    
    public function editar($id)
    {        
    }
        
}