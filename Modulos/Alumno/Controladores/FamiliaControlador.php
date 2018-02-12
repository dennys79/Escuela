<?php
require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'FamiliaModelo.php';
require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'Alumno.php';

require_once LIB_PATH . 'ValidarFormulario.php';


/**
 * Clase ObraSocial Controlador 
 */
class Alumno_Controladores_familiaControlador extends App_Controlador
{

    private $_alumno;

    public function __construct()
    {
        parent::__construct();
        $this->_alumno = new Alumno_Modelos_familiaModelo();
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
            if (isset($datos['id_familia']) && $datos['id_familia']!==NULL && $datos['id_familia']!=='') {
                $rtdo = $this->_alumno->editarFamilia($aGuardar, 'id_familia=' . $aGuardar['id_familia']);
            } else {
                unset($aGuardar['id_familia']);
                $rtdo = $this->_alumno->insertarFamiliarAlumno($aGuardar);
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
        $datos['guardar_familia'] = filter_input(INPUT_POST, 'guardar_familia', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_familia'] = filter_input(INPUT_POST, 'id_familia', FILTER_SANITIZE_NUMBER_INT);
        $datos['id_alumno'] = filter_input(INPUT_POST, 'id_alumno', FILTER_SANITIZE_NUMBER_INT);
        $datos['parentesco'] = filter_input(INPUT_POST, 'parentesco', FILTER_SANITIZE_STRING);
        $datos['nombreFamilia'] = filter_input(INPUT_POST, 'nombreFamilia', FILTER_SANITIZE_STRING);
        $datos['observacionesFamilia'] = filter_input(INPUT_POST, 'observacionesFamilia', FILTER_SANITIZE_STRING);
        return $datos;
    }
    
    private function _prepararDatos($datos)
    {
        $familia = array(
            'id_familia' => $datos['id_familia'],
            'id_alumno' => $datos['id_alumno'],
            'parentesco' => $datos['parentesco'],
            'nombre' => $datos['nombreFamilia'],
            'observaciones' => $datos['observacionesFamilia'],
        );
        return $familia;
    }
    
    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos)
    {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['nombreFamilia'], 'text', 'El valor no es válido');
        return $validar;
    }

    /**
     * Elimina los datos de un obraSocial
     * @param type $id 
     */
    public function eliminar()
    {
        $id = filter_input(INPUT_POST, 'id');
        echo $this->_alumno->eliminarFamiliarAlumno('id = ' . $id);
        
    }
}