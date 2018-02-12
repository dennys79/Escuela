<?php
require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'ContactoModelo.php';
require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'Alumno.php';

require_once LIB_PATH . 'ValidarFormulario.php';


/**
 * Clase ObraSocial Controlador 
 */
class Alumno_Controladores_contactoControlador extends App_Controlador
{

    private $_alumno;

    public function __construct()
    {
        parent::__construct();
        $this->_alumno = new Alumno_Modelos_contactoModelo();
    }

    public function index()
    {
    }

    public function nuevo()
    {
    }
    
    private function _control_edicion($id, $idOSocial)
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
        print_r($aGuardar);
        if ($errores->getRetEval()) {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (isset($datos['id_contacto']) && $datos['id_contacto']!==NULL && $datos['id_contacto']!=='') {
                $rtdo = $this->_alumno->editarContacto($aGuardar, 'id_contacto=' . $aGuardar['id_contacto']);
            } else {
                unset($aGuardar['id_contacto']);
                $rtdo = $this->_alumno->insertarContacto($aGuardar);
            }
            if ($rtdo) {
                $this->_vista->_mensaje = 'DATOS_GUARDADOS';
            } else {
                $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
            }
        }
        $this->redireccionar('mod=Alumno&cont=index&met=editar&id='.$datos['id_alumno']);
    }
    
    /**
     * Limpia los datos que vienen del Post
     * @return array $datos
     */
    private function _limpiarDatos()
    {
        $datos['guardar_contacto'] = filter_input(INPUT_POST, 'guardar_contacto', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_contacto'] = filter_input(INPUT_POST, 'id_contacto', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_alumno'] = filter_input(INPUT_POST, 'id_alumno', FILTER_SANITIZE_NUMBER_INT);
        $datos['tipoContacto'] = filter_input(INPUT_POST, 'tipoContacto', FILTER_SANITIZE_STRING);
        $datos['valorContacto'] = filter_input(INPUT_POST, 'valorContacto', FILTER_SANITIZE_STRING);
        $datos['observacionesContacto'] = filter_input(INPUT_POST, 'observacionesContacto', FILTER_SANITIZE_STRING);
        return $datos;
    }
    
    private function _prepararDatos()
    {
        $domicilio = array(
            'id_contacto' => parent::getPostParam('id_contacto'),
            'id_alumno' => parent::getPostParam('id_alumno'),
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
        echo $this->_alumno->eliminarContacto('id = ' . $id);
        
    }
}