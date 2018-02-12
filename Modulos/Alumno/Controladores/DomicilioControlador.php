<?php
require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'DomicilioModelo.php';
require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'Alumno.php';

require_once LIB_PATH . 'ValidarFormulario.php';


/**
 * Clase ObraSocial Controlador 
 */
class Alumno_Controladores_domicilioControlador extends App_Controlador
{

    private $_alumno;

    public function __construct()
    {
        parent::__construct();
        $this->_alumno = new Alumno_Modelos_domicilioModelo();
    }

    public function index()
    {
    }

    public function nuevo()
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
                $rtdo = $this->_alumno->editarDomicilio($aGuardar, 'id_domicilio=' . $aGuardar['id_domicilio']);
            } else {
                unset($aGuardar['id_domicilio']);
                $rtdo = $this->_alumno->insertarDomicilio($aGuardar);
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
        $datos['guardar_domicilio'] = filter_input(INPUT_POST, 'guardar_domicilio', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_domicilio'] = filter_input(INPUT_POST, 'id_domicilio', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_alumno'] = filter_input(INPUT_POST, 'id_alumno', FILTER_SANITIZE_NUMBER_INT);
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
    
    private function _prepararDatosDomicilio($datos)
    {
        $domicilio = array(
            'id_domicilio' => $datos['id_domicilio'],
            'id_alumno' => $datos['id_alumno'],
            'calle' => $datos['calle'],
            'casa_nro' => $datos['casa_nro'],
            'piso' => $datos['piso'],
            'depto' => $datos['depto'],
            'barrio' => $datos['barrio'],
            'cp' => $datos['cp'],
            'localidad' => $datos['localidad'],
            'provincia' => $datos['provincia'],
            'pais' => $datos['pais'],
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
//        $validar->ValidField($datos['calle'], 'text', 'La denominación no es válida');
        return $validar;
    }

    
}