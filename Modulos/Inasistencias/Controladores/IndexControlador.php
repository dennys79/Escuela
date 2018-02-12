<?php

require_once BASE_PATH . 'LibQ' . DS . 'ValidarFormulario.php';
require_once MODS_PATH . 'Inasistencias' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once MODS_PATH . 'Cursos' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once MODS_PATH . 'Ciclo' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once 'BarraHerramientasInasistencias.php';
require_once 'BotonesInasistencias.php';
require_once LIB_PATH . 'Esc_pdf.php';

/**
 * Clase Inasistencias Controlador 
 */
class Inasistencias_Controladores_IndexControlador extends App_Controlador {

    protected $_inasistencias;
    protected $_alumnos;
    protected $_cursos;
    protected $_ciclo;
    protected $_bt;
    protected $_bh;

    /**
     * Constructor de la clase Index
     * Inicializa los modelos 
     */
    public function __construct() {
        parent::__construct();
        $this->_inasistencias = new Inasistencias_Modelos_indexModelo();
        $this->_bh = new BarraHerramientasInasistencias();
        $this->_alumnos = new Alumno_Modelos_indexModelo();
        $this->_cursos = new Cursos_Modelos_indexModelo();
        $this->_ciclo = new Ciclo_Modelos_indexModelo();
    }

    public function index() {
        $this->isAutenticado();
        if (!$this->_inasistencias->comprobarTabla('inasistencias_alumnos')) {
            $this->_vista->setBodyOnLoad('crearTabla()');
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasIndex();
        $this->_vista->titulo = TITULO_INASISTENCIAS;
        $this->_vista->setVistaCss(
                array('dataTables.bootstrap.min', 'select.dataTables.min'));
        $this->_vista->setVistaJs(
                array('dataTables.bootstrap.min',
                    'dataTables.select.min',
                    'lista_inasistencias'
                )
        );
        $this->_vista->renderizar('index', 'inasistencias');
    }
    
    private function _obtenerFecha()
    {
        $getFecha = $this->getGetParam('fecha');
        if (isset($getFecha)) {
            $fecha = new LibQ_Fecha($getFecha);
        } else {
            $fecha = new LibQ_Fecha();
        }
        return $fecha;
    }

    /**
     * Método por defecto del módulo Alumno
     * Muestra una lista con los inasistenciass
     */
    public function inasistenciaAlumnos() {
        $this->isAutenticado();
//        $getFecha = $this->getGetParam('fecha');
        $curso = $this->getGetParam('curso');
        $fecha = $this->_obtenerFecha();        
        $ciclo = $this->_ciclo->getCicloActual();
        $this->_vista->fecha = LibQ_Fecha::getFechaBd($fecha->getFecha());
        $this->_vista->cursoSeleccionado = $curso;
        $this->_vista->cursos = $this->_cursos->getCursosDisponibles($ciclo->getCiclo());
        $this->_vista->inasistencias = $this->_inasistencias->getInasistenciasAlumnosFecha(
                'fecha="' . LibQ_Fecha::getFechaBd($fecha->getFecha()) . '"', 'id_curso=' . $curso);
        if ($this->getIntPost('guardar') == 1) {
            $condicion = 'fecha="' . LibQ_Fecha::getFechaBd($fecha->getFecha()) . '"';
            if (!$this->_inasistencias->existeInasistencia($condicion)) {
                $this->_guardarInasistencias();
            } else {
                $this->_editarInasistencias();
            }
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasIndex();
        $this->_vista->titulo = TITULO_INASISTENCIAS;
        $this->_vista->setVistaCss(
                array('dataTables.bootstrap.min', 'select.dataTables.min'));
        $this->_vista->setVistaJs(
                array('dataTables.bootstrap.min',
                    'dataTables.select.min',
                    'lista_inasistencias'
                )
        );
        $this->_vista->renderizar('inasistenciaAlumnos', 'inasistencias');
    }

    public function nuevo() {
        $this->isAutenticado();
        $this->_acl->acceso('nuevo_inasistencias');
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasNuevo();
        $this->_vista->titulo = TITULO_NUEVO_CICLOS;
        $this->_vista->setVistaJs(
                array(
                    'jquery.validate.min', 'validarNuevo',
                    'util', 'lista_inasistenciass'));
        $this->_vista->datos = INPUT_POST;
        if ($this->getIntPost('guardar') == 1) {
            $this->_guardar();
        }
        $this->_vista->renderizar('nuevo', 'Inasistencias');
    }

    public function editar($id) {
        $this->isAutenticado();
        $this->_acl->acceso('editar_inasistencias');
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasEditar($id);
        $idPac = $this->_controlId($id);
        $this->_vista->titulo = TITULO_EDITAR_CICLO;
        /** Cargo los archivos js */
        $this->_vista->setJs(array('tinymce/jscripts/tiny_mce/tiny_mce'));
        $this->_vista->setVistaJs(
                array(
                    'jquery.validate.min', 'validarNuevo',
                    'util', 'lista_inasistenciass'));
        /** Si el Post viene con editar = 1 */
        if ($this->getIntPost('editar') == 1) {
            $this->_guardar();
        }
        /** Si no es para guardar lleno el form con datos de la bd */
        $inasistencias = $this->_inasistencias->getInasistencias("id = " . $idPac);
        /** Envío los datos a la vista */
        $this->_vista->datos = $inasistencias;
        $this->_vista->renderizar('editar', 'Inasistencias');
    }

    private function _controlId($id) {
        /** Si no viene id en el POST envío al Index */
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('option=Inasistencias');
        }
        /** Si no encuentro el inasistencias envío al Index */
        $idInasistencias = $this->filtrarInt($id);
        if (!$this->_inasistencias->existeInasistencias("id = " . $idInasistencias)) {
            $this->redireccionar('option=Inasistencias');
        }
        return $idInasistencias;
    }

    private function _guardarInasistencias() {
        $rtdo = '';
        $datos = filter_input_array(INPUT_POST);
            unset($datos['guardar']);
            foreach ($datos as $index => $value) {
                $rtdo = $this->_insertarInasistencias($index, $value);
            }        
        if ($rtdo) {
            $this->_vista->_mensaje = 'DATOS_GUARDADOS';
        } else {
            $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
        }
        return $rtdo;
    }
    
    private function _editarInasistencias() {
        $rtdo = '';
        $datos = filter_input_array(INPUT_POST);
            unset($datos['guardar']);
            foreach ($datos as $index => $value) {
                $rtdo = $this->_updateInasistencias($index, $value);
            }        
        if ($rtdo) {
            $this->_vista->_mensaje = 'DATOS_GUARDADOS';
        } else {
            $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
        }
        return $rtdo;
    }

    private function _insertarInasistencias($index, $value) {
        $aGuardar['fecha'] = $this->getGetParam('fecha');
        $long = strlen($index)-13;
        $aGuardar['id_alumno'] = substr($index, 13, $long);
        $aGuardar['valor'] = $value;
        return $this->_inasistencias->insertarInasistencias($aGuardar);
    }
    
    private function _updateInasistencias($index, $value) {
//        $condicion = 'fecha = '.$this->getGetParam('fecha');
//        echo $index;
        $long = strlen($index)-13;
        $condicion = 'id = '.substr($index, 13, $long);
        $aGuardar['valor'] = $value;
//        echo $condicion;
        return $this->_inasistencias->editarInasistencias($aGuardar, $condicion);
    }

    /**
     * Limpia los datos que vienen del Post
     * @return array $datos
     */
    private function _limpiarDatos() {
//        var_dump(INPUT_POST);
        $datos['guardar'] = filter_input(INPUT_POST, 'guardar', FILTER_SANITIZE_NUMBER_INT);
//        $datos['editar'] = filter_input(INPUT_POST, 'editar', FILTER_SANITIZE_NUMBER_INT);
//        $datos['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
//        $datos['inasistencias'] = filter_input(INPUT_POST, 'inasistencias', FILTER_SANITIZE_STRING);
//        $datos['observaciones'] = filter_input(INPUT_POST, 'observaciones', FILTER_SANITIZE_STRING);
        return INPUT_POST;
    }

    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos) {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['inasistencias'], 'int', 'El Inasistencias no es válido');
        return $validar;
    }

    private function _prepararDatosInasistencias($datos) {
        $datosInasistencias = array(
            'id' => $datos['id'],
            'inasistencias' => $datos['inasistencias'],
            'observaciones' => $datos['observaciones'],
        );
        return $datosInasistencias;
    }

    /**
     * Elimina los datos de un alumno
     * @param int $id 
     */
    public function eliminar() {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        if (is_null($id)) {
            echo 'es null' . $id;
        }

        if (!$id) {
            echo 'es falso' . $id;
        }
        echo $this->_inasistencias->eliminarInasistencias('id = ' . $id);
    }

    public static function getInasistenciasActual() {
        return $this->_inasistencias->getInasistenciasActual();
    }

    public function crearTabla() {
        $sql = "CREATE TABLE escuela_inasistencias_alumnos (
            id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            fecha date NOT NULL,
            id_alumno int(11) NOT NULL,
            valor int(11) NOT NULL,
            observaciones varchar(50) NOT NULL
            COLLATE utf8_spanish_ci NOT NULL);";
        $r = $this->_inasistencias->crearTabla($sql);
        return $r;
    }

    public function setInasistenciasActual() {
        $idInasistencias = $this->getIntPost('idInasistencias');
        $actual = $this->_inasistencias->getInasistenciasActual();
        if ($idInasistencias <> $actual->getId()) {
            $q = $this->_inasistencias->editarInasistencias(array('actual' => 0), 'id=' . $actual->getId());
            $s = $this->_inasistencias->editarInasistencias(array('actual' => 1), 'id=' . $idInasistencias);
        }
//        echo $q . $s;
    }

    public function imprimirLista() {
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista Gral. de Inasistenciass', 0, 1, 'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20);
        $pdf->Cell(12, 10, 'Nro', 0, 0);
        $pdf->Cell(90, 10, 'Inasistencias', 0, 0);
        $pdf->Cell(0, 10, 'Observaciones', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $datos = $this->_inasistencias->getInasistenciass();
        $i = 1;
        foreach ($datos as $inasistencias) {
            $pdf->Cell(20);
            $pdf->Cell(12, 10, $i, 0, 0);
            $pdf->Cell(90, 10, utf8_decode($inasistencias->getInasistencias()), 0, 0);
            $pdf->Cell(0, 10, $inasistencias->getObservaciones(), 0, 1);
            $i++;
        }
        $pdf->Output();
    }

    public function getAllInscriptos() {
        return $this->_alumnos->getAlumnosInasistenciaBySql("Select T1.* From escuela_alumnos T1
            Inner Join escuela_inscripciones T2
            ON T1.id = T2.id_alumno Order by apellidos");
    }

}
