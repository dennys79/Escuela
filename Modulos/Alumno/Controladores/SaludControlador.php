<?php

require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'SaludModelo.php';
require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'Alumno.php';

require_once LIB_PATH . 'ValidarFormulario.php';

/**
 * Clase Salud Controlador 
 */
class Alumno_Controladores_saludControlador extends App_Controlador {

    private $_alumno;

    public function __construct() {
        parent::__construct();
        $this->_alumno = new Alumno_Modelos_saludModelo();
    }

    public function index() {
        
    }

    public function getDiagnosticos() {
        return $this->_alumno->getDiagnosticos();
    }

    public function nuevo() {
        
    }

    private function _control_edicion($id, $idOSocial) {
        
    }

    public function editar($id) {
        
    }

    public function guardar() {
        $rtdo = '';
        $datos = $this->_limpiarDatos();
        $errores = $this->_validarPost($datos);
        $aGuardar = $this->_prepararDatos($datos);
        if ($errores->getRetEval()) {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (isset($datos['id_salud']) && $datos['id_salud'] !== NULL && $datos['id_salud'] !== '') {
                $condicion = 'id =' . $aGuardar['id'];
                unset($aGuardar['id_salud']);
                $rtdo = $this->_alumno->editarSalud($aGuardar, $condicion);
            } else {
                unset($aGuardar['id_salud']);
                $rtdo = $this->_alumno->insertarSalud($aGuardar);
            }
            $this->_guardarDiagnostico($aGuardar);
            if ($rtdo) {
                $this->_vista->_mensaje = 'DATOS_GUARDADOS';
            } else {
                $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
            }
        }
        $this->redireccionar('mod=Alumno&cont=index&met=editar&id=' . $datos['id_alumno']);
    }

    private function _guardarDiagnostico($datos) {
        if (!$this->_existeDiagnostico(substr($datos['diagnostico'],0, strlen($datos['diagnostico'])-2))) {
            $diag = $this->_alumno->insertarDiagnostico(array('diagnostico' => substr($datos['diagnostico'],0, strlen($datos['diagnostico'])-2)));
        }
    }

    private function _existeDiagnostico($dato) {
        $diag = $this->_alumno->existeDiagnostico($dato);
    }

    /**
     * Limpia los datos que vienen del Post
     * @return array $datos
     */
    private function _limpiarDatos() {
        $datos['id_salud'] = filter_input(INPUT_POST, 'id_salud', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_alumno'] = filter_input(INPUT_POST, 'id_alumno', FILTER_SANITIZE_NUMBER_INT);
        $datos['diagnostico'] = filter_input(INPUT_POST, 'diagnostico', FILTER_SANITIZE_STRING);
        $datos['medico_diagnostico'] = filter_input(INPUT_POST, 'medico_diagnostico', FILTER_SANITIZE_NUMBER_INT);
        return $datos;
    }

    private function _prepararDatos($datos) {
        $salud = array(
            'id' => $datos['id_salud'],
            'id_alumno' => $datos['id_alumno'],
            'diagnostico' => $datos['diagnostico'],
            'medico_diagnostico' => $datos['medico_diagnostico'],
        );
        return $salud;
    }

    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos) {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['id_salud'], 'int', 'El identificador id_salud no es válido');
        return $validar;
    }

    /**
     * Elimina los datos de un obraSocial
     * @param type $id 
     */
    public function eliminar() {
        $id = filter_input(INPUT_POST, 'id');
        echo $this->_alumno->eliminarSaludAlumno('id = ' . $id);
    }

}
