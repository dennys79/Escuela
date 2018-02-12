<?php

require_once BASE_PATH . 'LibQ' . DS . 'ValidarFormulario.php';
require_once MODS_PATH . 'Cursos' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once MODS_PATH . 'Ciclo' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once 'BarraHerramientasCurso.php';
require_once 'BotonesCurso.php';
require_once LIB_PATH . 'Esc_pdf.php';

/**
 * Clase Curso Controlador 
 */
class Cursos_Controladores_IndexControlador extends App_Controlador {

    protected $_curso;
    protected $_bt;
    protected $_bh;
    protected $_alumnos;
    protected $_ciclo;

    /**
     * Constructor de la clase Index
     * Inicializa los modelos 
     */
    public function __construct() {
        parent::__construct();
        $this->_curso = new Cursos_Modelos_indexModelo();
        $this->_alumnos = new Alumno_Modelos_indexModelo();
        $this->_ciclo = new Ciclo_Modelos_indexModelo();
        $this->_bh = new BarraHerramientasCurso();
    }

    /**
     * Método por defecto del módulo Alumno
     * Muestra una lista con los cursos
     */
    public function index() {
        $this->isAutenticado();
        if (!$this->_ciclo->comprobarTabla('cursos')) {
            $this->_vista->setBodyOnLoad('crearTabla()');
        } else {
            $datos = $this->_curso->getCursos();
            $this->_vista->datos = $datos;
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasIndex();
        $this->_vista->titulo = TITULO_CURSOS;
        $this->_vista->setVistaCss(
                array('dataTables.bootstrap.min', 'select.dataTables.min'));
        $this->_vista->setVistaJs(
                array(
                    'dataTables.bootstrap.min',
                    'dataTables.select.min',
                    'lista_cursos'
                )
        );
        $this->_vista->renderizar('index', 'curso');
    }

    public function nuevo() {
        $this->isAutenticado();
        $this->_acl->acceso('nuevo_curso');
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasNuevo();
        $this->_vista->titulo = TITULO_NUEVO_CURSO;
        $this->_vista->setVistaJs(
                array(
                    'jquery.validate.min', 'validarNuevo',
                    'util', 'lista_cursos'));
        $this->_vista->datos = INPUT_POST;
        if ($this->getIntPost('guardar') == 1) {
            $this->_guardar();
        }
        $this->_vista->renderizar('nuevo', 'Curso');
    }

    public function editar($id) {
        $this->isAutenticado();
        $this->_acl->acceso('editar_curso');
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasEditar($id);
        $idPac = $this->_controlId($id);
        $this->_vista->titulo = TITULO_EDITAR_CURSO;
        /** Cargo los archivos js */
        $this->_vista->setVistaJs(
                array(
                    'jquery.validate.min', 'validarNuevo',
                    'util', 'lista_cursos'));
        $this->_vista->setJs(array('tinymce/jscripts/tiny_mce/tiny_mce'));
        /** Si el Post viene con editar = 1 */
        if ($this->getIntPost('editar') == 1) {
            $this->_guardar();
        }
        /** Si no es para guardar lleno el form con datos de la bd */
        $curso = $this->_curso->getCurso("id = " . $idPac);
        /** Envío los datos a la vista */
        $this->_vista->datos = $curso;
        $this->_vista->renderizar('editar', 'Curso');
    }

    public function editarLista() {
        $this->isAutenticado();
        $this->_acl->acceso('editar_lista_cursos');
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasEditarLista();
        $cicloActual = $this->_ciclo->getCicloActual();
        $cursosActuales = $this->_curso->getAnyCursos('id_ciclo=' . $cicloActual->getId());
        $cursosDisponibles = $this->_curso->getCursosDisponibles($cicloActual->getId());
        $this->_vista->titulo = TITULO_EDITAR_LISTA . ' ' . $cicloActual;
        $this->_vista->cicloActual = $cicloActual;
        $this->_vista->cursos = $cursosDisponibles;
        $this->_vista->cursosEnCiclo = $cursosActuales;
        /** Cargo los archivos js */
        $this->_vista->setVistaJs(
                array(
                    'jquery.validate.min', 'validarNuevo',
                    'util', 'lista_cursos'));
        $this->_vista->renderizar('editarLista', 'Curso');
    }

    public function inscribir($id) {
        $this->isAutenticado();
        $this->_acl->acceso('inscribir_curso');
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasInscribir($id);
        $idAl = $this->_controlId($id);
        /** Cargo los archivos js */
        $this->_vista->setVistaJs(array(
            'jquery.validate.min', 'validarNuevo',
            'util', 'lista_cursos'));
        /** Si el Post viene con editar = 1 */
        if ($this->getIntPost('editar') == 1) {
            $this->_inscribir();
        }
        $curso = $this->_curso->getCurso("id = " . $idAl);
        $ciclo = $this->_ciclo->getCicloActual();
        $alumnos = $this->getAlumnosParaInscribir($ciclo->getId());
        $inscriptos = $this->getInscriptos($curso, $ciclo->getId());
        /** Envío los datos a la vista */
        $this->_vista->titulo = TITULO_INSCRIBIR_CURSO . ' ' . $curso->getCurso(). ' en el Ciclo '.$ciclo;
        $this->_vista->alumnos = $alumnos;
        $this->_vista->cicloActual = $ciclo;
        $this->_vista->totalAlumnos = count($alumnos);
        $this->_vista->totalInscriptos = count($inscriptos);
        $this->_vista->inscriptos = $inscriptos;
        $this->_vista->datos = $curso;
        $this->_vista->renderizar('inscribir', 'Curso');
    }

    public function inscribirAlumno($id) {
        $this->isAutenticado();
        $this->_acl->acceso('inscribir_curso');
        $datos['id_curso'] = $id;
        $datos['id_ciclo'] = $this->_ciclo->getCicloActual()->getId();
        $datos['id_alumno'] = $this->getGetParam('idAlumno');
        echo $this->_inscribir($datos);
    }

    public function desinscribirAlumno($id) {
        $this->isAutenticado();
        $this->_acl->acceso('inscribir_curso');
        $ciclo = $this->_ciclo->getCicloActual()->getId();
        $alumno = $this->getGetParam('idAlumno');
        $condicion = "id_curso = $id AND id_ciclo = $ciclo AND id_alumno = $alumno";
        $r = $this->_desinscribir($condicion);
        echo $condicion . ' = ' . $r;
    }

    private function _inscribir($datos) {

        return $this->_curso->inscribirAlumno($datos);
    }

    private function _desinscribir($datos) {

        return $this->_curso->desinscribirAlumno($datos);
    }

    public function getAlumnos($idCiclo) {
        return $this->_alumnos->getAlumnosBySql('Select T1.* From escuela_alumnos T1
            Left Outer Join escuela_inscripciones T2
            ON T1.id = T2.id_alumno where T2.id_alumno is null Order by T1.apellidos');
    }

    public function getAlumnosParaInscribir($idCiclo) {
        $todos = $this->_alumnos->getAlumnosBySql('Select * From escuela_alumnos ORDER BY apellidos');
        $copiaTodos = $todos;
        $delCiclo = $this->_alumnos->getAlumnosBySqlResource('SELECT * FROM escuela_inscripciones'
                . ' WHERE id_ciclo = ' . $idCiclo);
        $i = 0;
        foreach ($todos as $alumno) {
            foreach ($delCiclo as $inscripto) {
                if ($alumno->getId() == $inscripto['id_alumno']) {
                    unset($copiaTodos[$i]);
                }
            }
            $i++;
        }
        return $copiaTodos;
    }

    public function getInscriptos($idCurso, $idCiclo) {
        if (is_string($idCurso)) {
            $curso_id = intval($idCurso);
        } else {
            $curso_id = $idCurso->getId();
        }
        return $this->_alumnos->getAlumnosBySql("Select T1.* From escuela_alumnos T1
            Inner Join escuela_inscripciones T2
            ON T1.id = T2.id_alumno WHERE T2.id_curso = $curso_id AND T2.id_ciclo = $idCiclo ORDER BY apellidos");
    }

    private function _controlId($id) {
        /** Si no viene id en el POST envío al Index */
        if (!$this->filtrarInt($id)) {
            $this->redireccionar('option=Curso');
        }
        /** Si no encuentro el curso envío al Index */
        $idCurso = $this->filtrarInt($id);
        if (!$this->_curso->existeCurso("id = " . $idCurso)) {
            $this->redireccionar('option=Curso');
        }
        return $idCurso;
    }

    private function _guardar() {
        $rtdo = '';
        $datos = $this->_limpiarDatos();
        $errores = $this->_validarPost($datos);
        $aGuardarCurso = $this->_prepararDatosCurso($datos);
        if ($errores->getRetEval()) {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (isset($datos['editar'])) {
                $rtdo = $this->_curso->editarCurso($aGuardarCurso, 'id=' . $aGuardarCurso['id']);
            } else {
                unset($aGuardarCurso['id']);
                $rtdo = $this->_curso->insertarCurso($aGuardarCurso);
            }
            if ($rtdo) {
                $this->_vista->_mensaje = 'DATOS_GUARDADOS';
            } else {
                $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
            }
        }
        return $rtdo;
    }

    /**
     * Limpia los datos que vienen del Post
     * @return array $datos
     */
    private function _limpiarDatos() {
        $datos['guardar'] = filter_input(INPUT_POST, 'guardar', FILTER_SANITIZE_NUMBER_INT);
        $datos['editar'] = filter_input(INPUT_POST, 'editar', FILTER_SANITIZE_NUMBER_INT);
        $datos['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $datos['curso'] = filter_input(INPUT_POST, 'curso', FILTER_SANITIZE_STRING);
        $datos['observaciones'] = filter_input(INPUT_POST, 'observaciones', FILTER_SANITIZE_STRING);
        return $datos;
    }

    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos) {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['curso'], 'int', 'El Curso no es válido');
        return $validar;
    }

    private function _prepararDatosCurso($datos) {
        $datosCurso = array(
            'id' => $datos['id'],
            'curso' => $datos['curso'],
            'observaciones' => $datos['observaciones'],
        );
        return $datosCurso;
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
        echo $this->_curso->eliminarCurso('id = ' . $id);
    }

    public function crearTabla() {
        $sql = "CREATE TABLE escuela_cursos (
            id int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
            curso varchar(50) NOT NULL,
            observaciones varchar(255) 
            COLLATE utf8_spanish_ci NOT NULL);";
        $r = $this->_ciclo->crearTabla($sql);
        $this->redireccionar('?mod=Cursos?met=index');
        return $r;
    }

    public function quitarCurso($idCurso) {
        $this->isAutenticado();
        $this->_acl->acceso('editar_lista_cursos');
        $ciclo = $this->_ciclo->getCicloActual()->getId();
        $condicion = "id_curso = $idCurso AND id_ciclo = $ciclo";
        echo $this->_quitarCurso($condicion);
    }

    private function _quitarCurso($datos) {

        return $this->_curso->quitarCurso($datos);
    }

    public function agregarCurso($idCurso) {
        $this->isAutenticado();
        $this->_acl->acceso('editar_lista_cursos');
        $datos['id_curso'] = $idCurso;
        $datos['id_ciclo'] = $this->_ciclo->getCicloActual()->getId();
        echo $this->_agregarCurso($datos);
    }

    private function _agregarCurso($datos) {

        return $this->_curso->agregarCurso($datos);
    }

    public function imprimirLista() {
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista Gral. de Cursos', 0, 1, 'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20);
        $pdf->Cell(12, 10, 'Nro', 0, 0);
        $pdf->Cell(90, 10, 'Curso', 0, 0);
        $pdf->Cell(0, 10, 'Observaciones', 0, 1);
        $pdf->SetFont('Arial', '', 12);
        $datos = $this->_curso->getCursos();
        $i = 1;
        foreach ($datos as $curso) {
            $pdf->Cell(20);
            $pdf->Cell(12, 10, $i, 0, 0);
            $pdf->Cell(90, 10, utf8_decode($curso->getCurso()), 0, 0);
            $pdf->Cell(0, 10, $curso->getObservaciones(), 0, 1);
            $i++;
        }
        $pdf->Output();
    }

    public function imprimirListaAlumnos($idCurso) {
        $curso = $this->_curso->getCurso('id = ' . $idCurso);
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista de Alumnos del Curso ' . utf8_decode($curso->getCurso()), 0, 1, 'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20);
        $pdf->Cell(12, 10, 'Nro', 0, 0);
        $pdf->Cell(50, 10, 'Apellido', 0, 0);
        $pdf->Cell(70, 10, 'Nombre', 0, 0);
        $pdf->Cell(0, 10, 'Documento', 0, 1, 'R');
        $pdf->SetFont('Arial', '', 12);
        $datos = $this->getInscriptos($idCurso);
        $i = 1;
        foreach ($datos as $alumno) {
            $pdf->Cell(20);
            $pdf->Cell(12, 10, $i, 0, 0);
            $pdf->Cell(50, 10, utf8_decode($alumno->getApellidos()), 0, 0);
            $pdf->Cell(70, 10, $alumno->getNombres(), 0, 0);
            $pdf->Cell(0, 10, $alumno->getNro_doc(), 0, 1, 'R');
            $i++;
        }
        $pdf->Output();
    }

    /**
     * Método por defecto del módulo Alumno
     * Muestra una lista con los cursos
     */
    public function listarAlumnos($idCurso) {
        $this->isAutenticado();
        $ciclo = $this->_ciclo->getCicloActual()->getId();
        $curso = $this->_curso->getCurso('id = ' . $idCurso);
        $inscriptos = $this->getInscriptos($idCurso, $ciclo);
        $this->_vista->datos = $inscriptos;
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasListarAlumnos($idCurso);
        $this->_vista->titulo = TITULO_CURSOS_ALUMNOS . ' ' . $curso->getCurso(). ' en el Ciclo '.$this->_ciclo->getCicloActual();
        $this->_vista->varones = $this->_discriminarSexo($inscriptos, "VARON");
        $this->_vista->mujeres = $this->_discriminarSexo($inscriptos, "MUJER");
        $this->_vista->curso_id = $curso->getId();
        $this->_vista->setVistaCss(
                array('dataTables.bootstrap.min', 'select.dataTables.min'));
        $this->_vista->setVistaJs(
                array(
                    'dataTables.bootstrap.min',
                    'dataTables.select.min',
                    'lista_alumnos'
                )
        );
        $this->_vista->renderizar('listarAlumnos', 'curso');
    }

    private function _discriminarSexo($inscriptos, $sexo) {
        $alumnos = array();
        foreach ($inscriptos as $alumno) {
            if ($alumno->getSexo() == $sexo) {
                $alumnos[] = $alumno;
            }
        }
        return $alumnos;
    }

}
