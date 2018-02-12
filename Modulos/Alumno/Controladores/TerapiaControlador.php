<?php
require_once MODS_PATH . 'Paciente' . DS . 'Modelos' . DS . 'TerapiaModelo.php';
require_once MODS_PATH . 'Paciente' . DS . 'Modelos' . DS . 'Paciente.php';

require_once LIB_PATH . 'ValidarFormulario.php';


/**
 * Clase ObraSocial Controlador 
 */
class Paciente_Controladores_terapiaControlador extends App_Controlador
{

    private $_paciente;

    public function __construct()
    {
        parent::__construct();
        $this->_paciente = new Paciente_Modelos_terapiaModelo();
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
//        print_r($aGuardar);
        if ($errores->getRetEval()) {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (isset($datos['id_terapia']) && $datos['id_terapia']!==NULL && $datos['id_terapia']!=='') {
                $rtdo = $this->_paciente->editarTerapia($aGuardar, 'id_terapia=' . $aGuardar['id_terapia']);
            } else {
                unset($aGuardar['id_terapia']);
                $rtdo = $this->_paciente->insertarTerapiaPaciente($aGuardar);
            }
            if ($rtdo) {
                $this->_vista->_mensaje = 'DATOS_GUARDADOS';
            } else {
                $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
            }
        }
        $this->redireccionar('mod=Paciente&cont=index&met=editar&id='.$datos['id_paciente']);
    }
    
    /**
     * Limpia los datos que vienen del Post
     * @return array $datos
     */
    private function _limpiarDatos()
    {
        $datos['guardar_terapia'] = filter_input(INPUT_POST, 'guardar_terapia', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_terapia'] = filter_input(INPUT_POST, 'id_terapia', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_paciente'] = filter_input(INPUT_POST, 'id_paciente', FILTER_SANITIZE_STRING);
        $datos['lista_terapia'] = filter_input(INPUT_POST, 'lista_terapia', FILTER_SANITIZE_NUMBER_INT);
        $datos['profesional'] = filter_input(INPUT_POST, 'profesional', FILTER_SANITIZE_NUMBER_INT);
        $datos['cantidad'] = filter_input(INPUT_POST, 'cantidad', FILTER_SANITIZE_NUMBER_INT);
        $datos['observacionesTerapia'] = filter_input(INPUT_POST, 'observacionesTerapia', FILTER_SANITIZE_STRING);
        print_r($datos);
        return $datos;
    }
    
    private function _prepararDatos($datos)
    {
        $terapia = array(
            'id_terapia' => $datos['id_terapia'],
            'idPaciente' => $datos['id_paciente'],
            'idTerapia' => $datos['lista_terapia'],
            'idProfesional' => $datos['profesional'],
            'sesiones' => $datos['cantidad'],
            'observaciones' => $datos['observacionesTerapia']
        );
        return $terapia;
    }
    
    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos)
    {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['cantidad'], 'numeric', 'El valor no es válido');
        return $validar;
    }

    /**
     * Elimina los datos de un obraSocial
     * @param type $id 
     */
    public function eliminar()
    {
        $id = filter_input(INPUT_POST, 'id');
        echo $this->_paciente->eliminarTerapiaPaciente('id = ' . $id);
        
    }
}