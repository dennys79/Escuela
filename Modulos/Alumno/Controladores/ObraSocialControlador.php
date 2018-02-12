<?php
require_once MODS_PATH . 'Paciente' . DS . 'Modelos' . DS . 'OSocialModelo.php';
require_once MODS_PATH . 'Paciente' . DS . 'Modelos' . DS . 'Paciente.php';

require_once LIB_PATH . 'ValidarFormulario.php';


/**
 * Clase ObraSocial Controlador 
 */
class Paciente_Controladores_obraSocialControlador extends App_Controlador
{

    private $_paciente;

    public function __construct()
    {
        parent::__construct();
        $this->_paciente = new Paciente_Modelos_oSocialModelo();
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
//            print_r($errores->getErrString());
        } else {
            if (isset($datos['id']) && $datos['id']!==NULL && $datos['id']!=='') {
                $rtdo = $this->_paciente->editarOSocialPaciente($aGuardar, 'id=' . $aGuardar['id']);
            } else {
                unset($aGuardar['id_terapia']);
                $rtdo = $this->_paciente->insertarOSocialPaciente($aGuardar);
            }
            if ($rtdo) {
                $this->_vista->_mensaje = 'DATOS_GUARDADOS';
            } else {
                $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
            }
        }
        $this->redireccionar('mod=Paciente&cont=index&met=editar&id='.$datos['idPaciente']);
    }
    
    /**
     * Limpia los datos que vienen del Post
     * @return array $datos
     */
    private function _limpiarDatos()
    {
        $datos['guardarOSPaciente'] = filter_input(INPUT_POST, 'guardarOSPaciente', FILTER_SANITIZE_NUMBER_INT);
        $datos['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $datos['idDatosOSocial'] = filter_input(INPUT_POST, 'idDatosOSocial', FILTER_SANITIZE_NUMBER_INT);
        $datos['idPaciente'] = filter_input(INPUT_POST, 'idPaciente', FILTER_SANITIZE_STRING);
        $datos['idOSocial'] = filter_input(INPUT_POST, 'idOSocial', FILTER_SANITIZE_NUMBER_INT);
        $datos['idObraSocial'] = filter_input(INPUT_POST, 'idObraSocial', FILTER_SANITIZE_NUMBER_INT);
        $datos['nro_afiliado'] = filter_input(INPUT_POST, 'nro_afiliado', FILTER_SANITIZE_STRING);
        $datos['observacionesOs'] = filter_input(INPUT_POST, 'observacionesOs', FILTER_SANITIZE_STRING);
//        print_r($datos);
        return $datos;
    }
    
    private function _prepararDatos($datos)
    {
        $os_paciente = array(
            'id' => $datos['id'],
            'idOSocial' => $datos['idObraSocial'],
            'idPaciente' => $datos['idPaciente'],
            'nro_afiliado' => $datos['nro_afiliado'],
            'pacos_observaciones' => $datos['observacionesOs'],
        );
        return $os_paciente;
    }
    
    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos)
    {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['nro_afiliado'], 'text', 'El valor no es válido');
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