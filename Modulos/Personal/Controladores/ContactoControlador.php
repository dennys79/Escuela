<?php
require_once MODS_PATH . 'Personal' . DS . 'Modelos' . DS . 'ContactoModelo.php';
require_once LIB_PATH . 'ValidarFormulario.php';

/**
 * Clase Personal Controlador 
 */
class Personal_Controladores_contactoControlador extends App_Controlador
{

    private $_personal;

    public function __construct()
    {
        parent::__construct();
        $this->_personal = new Personal_Modelos_contactoModelo();
    }

    public function index()
    {
    }

    public function nuevo()
    {
    }

    public function editar($id)
    {        
    }
    
    public function guardar()
    {
        $rtdo = '';
        $datos = $this->_limpiarDatos();
        $errores = $this->_validarPost($datos);
        $aGuardar = $this->_prepararDatos($datos);
//        print_r($aGuardar);
        if ($errores->getRetEval()) {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (isset($datos['id_contacto']) && $datos['id_contacto']!==NULL && $datos['id_contacto']!=='') {
                $rtdo = $this->_personal->editarContacto($aGuardar, 'id_contacto=' . $aGuardar['id_contacto']);
            } else {
                unset($aGuardar['id_contacto']);
                $rtdo = $this->_personal->insertarContacto($aGuardar);
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
        $datos['guardar_contacto'] = filter_input(INPUT_POST, 'guardar_contacto', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_contacto'] = filter_input(INPUT_POST, 'id_contacto', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_personal'] = filter_input(INPUT_POST, 'id_personal', FILTER_SANITIZE_NUMBER_INT);
        $datos['tipoContacto'] = filter_input(INPUT_POST, 'tipoContacto', FILTER_SANITIZE_STRING);
        $datos['valorContacto'] = filter_input(INPUT_POST, 'valorContacto', FILTER_SANITIZE_STRING);
        $datos['observacionesContacto'] = filter_input(INPUT_POST, 'observacionesContacto', FILTER_SANITIZE_STRING);
        return $datos;
    }
    
    private function _prepararDatos()
    {
        $domicilio = array(
            'id_contacto' => parent::getPostParam('id_contacto'),
            'id_personal' => parent::getPostParam('id_personal'),
            'tipoContacto' => parent::getPostParam('tipoContacto'),
            'valorContacto' => parent::getPostParam('valorContacto'),
            'observacionesContacto' => parent::getPostParam('observacionesContacto'),
        );
        return $domicilio;
    }
    
    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos)
    {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['valorContacto'], 'text', 'El valor no es válido');
        return $validar;
    }
    
    /**
     * Elimina los datos de un obraSocial
     * @param type $id 
     */
    public function eliminar()
    {
        $id = filter_input(INPUT_POST, 'id');
        echo $this->_personal->eliminarContacto('id = ' . $id);
    }

}