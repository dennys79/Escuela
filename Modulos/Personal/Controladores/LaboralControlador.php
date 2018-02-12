<?php
require_once MODS_PATH . 'Personal' . DS . 'Modelos' . DS . 'LaboralModelo.php';
require_once LIB_PATH . 'ValidarFormulario.php';

/**
 * Clase Personal Controlador 
 */
class Personal_Controladores_laboralControlador extends App_Controlador
{

    private $_personal;

    public function __construct()
    {
        parent::__construct();
        $this->_personal = new Personal_Modelos_laboralModelo();
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
        if ($errores->getRetEval()) {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (isset($datos['id']) && $datos['id']!==NULL && $datos['id']!=='') {
                $rtdo = $this->_personal->editarDatosLaborales($aGuardar, 'id=' . $aGuardar['id']);
            } else {
                unset($aGuardar['id']);
                $rtdo = $this->_personal->insertarDatosLaborales($aGuardar);
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
        $datos['guardarDatosLaborales'] = filter_input(INPUT_POST, 'guardarDatosLaborales', FILTER_SANITIZE_NUMBER_INT);
        $datos['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_personal'] = filter_input(INPUT_POST, 'id_personal', FILTER_SANITIZE_NUMBER_INT);
        $datos['puesto'] = filter_input(INPUT_POST, 'valorOcupacionEmpresa', FILTER_SANITIZE_NUMBER_INT);
        $datos['fechaIngreso'] = filter_input(INPUT_POST, 'fechaIngreso', FILTER_SANITIZE_STRING);
        $datos['observaciones'] = filter_input(INPUT_POST, 'observacionesDatosLaborales', FILTER_SANITIZE_STRING);
        return $datos;
    }
    
    private function _prepararDatos($datos)
    {
        $aGuardar = array(
            'id' => $datos['id'],
            'id_personal' => $datos['id_personal'],
            'puesto' => $datos['puesto'],
            'fechaIngreso' => $datos['fechaIngreso'],
            'observaciones' => $datos['observaciones'],
        );
        return $aGuardar;
    }
    
    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos)
    {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['puesto'], 'numeric', 'El valor no es válido');
        return $validar;
    }
    
    /**
     * Elimina los datos de un obraSocial
     * @param type $id 
     */
    public function eliminar()
    {
        $id = filter_input(INPUT_POST, 'id');
        echo $this->_personal->eliminarDatosLaborales('id = ' . $id);
    }

}