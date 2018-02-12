<?php

//require_once MODS_PATH . 'Personal' . DS . 'Modelos' . DS . 'Personal.php';
require_once 'Curso.php';
require_once APP_PATH . 'Modelo.php';

/**
 * Clase Modelo Alumno que extiende de la clase Modelo
 */
class Cursos_Modelos_indexModelo extends App_Modelo {

    private $_verEliminados = 0;

    /**
     * Clase constructora 
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Obtiene un array con los cursos
     * @return Resource 
     */
    public function getCursos() {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'cursos ORDER BY curso';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearCursos($this->_db->fetchall());
    }

    /**
     * Crea un array de cursos
     * @param Array $lista
     * @return \Alumno
     */
    public function _crearCursos($lista) {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = $this->_crearCurso($datos);
            }
        }
        return $resultado;
    }

    /**
     * Crea un curso
     * @param Array $datos
     * @return \Alumno
     */
    public function _crearCurso($datos) {
        $curso = new Curso_Modelos_Curso($datos);
        return $curso;
    }

    /**
     * Obtiene los datos de un curso
     * @param
     * @return Resource 
     */
    public function getCurso($where) {
        $sql = "SELECT * FROM " . PRE_TABLE . "cursos WHERE $where";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearCurso($this->_db->fetchRow());
    }

    /**
     * Obtiene una lista de cursos según criterio
     * @param string $where
     * @return Resource 
     */
    public function getAnyCursos($where) {
        $cursos = array();
        $sql = "SELECT * FROM " . PRE_TABLE . "ciclo_cursos WHERE $where";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $lista = $this->_db->fetchAll();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $idCurso) {
                $cursos[] = $this->getCurso('id=' . $idCurso['id_curso']);
            }
        }
        return $cursos;
    }

    public function getCursosDisponibles($ciclo) {
        $cursos = array();
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'cursos';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $todos = $this->_db->fetchAll();
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'ciclo_cursos WHERE id_ciclo=' . $ciclo;
        $this->_db->query($sql);
        $this->_db->setTipoDatos('Array');
        $existentes = $this->_db->fetchAll();
        $ttodos = $todos;
        if (is_array($existentes) and count($existentes) > 0) {
            $ttodos = $this->_filtrarExistentes($existentes, $todos, $ttodos);
            $cursos = $this->_crearCursos($ttodos);
        } else {
            $cursos = $this->_crearCursos($todos);
        }
        return $cursos;
    }

    private function _filtrarExistentes($existentes, $todos, $ttodos) {
        foreach ($existentes as $value) {
            $i = 0;
            foreach ($todos as $value2) {
                if ($value['id_curso'] == $value2['id']) {
                    unset($ttodos[$i]);
                    $i++;
                }
                $i++;
            }
        }
        return $ttodos;
    }

    /**
     * Verifica que exista un curso
     * @param $where parametro de consulta
     * @return boolean
     */
    public function existeCurso($where) {
        $retorno = false;
        $sql = "SELECT * FROM " . PRE_TABLE . "cursos WHERE $where";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        if ($this->_db->fetchRow()) {
            $retorno = true;
        }
        return $retorno;
    }

    public function insertarCurso(array $valores) {
        return $this->_db->insert(PRE_TABLE . 'cursos', $valores);
    }

    public function editarCurso(array $valores, $condicion) {
        return $this->_db->editar(PRE_TABLE . 'cursos', $valores, $condicion);
    }

    public function eliminarCurso($condicion) {
        return $this->_db->eliminar(PRE_TABLE . 'cursos', $condicion);
    }

    public function inscribirAlumno(array $valores) {
        return $this->_db->insert(PRE_TABLE . 'inscripciones', $valores);
    }

    public function desinscribirAlumno($condicion) {
        return $this->_db->eliminar(PRE_TABLE . 'inscripciones', $condicion);
    }
    
    public function quitarCurso($condicion) {
        return $this->_db->eliminar(PRE_TABLE . 'ciclo_cursos', $condicion);
    }
    
    public function agregarCurso(array $valores) {
        return $this->_db->insert(PRE_TABLE . 'ciclo_cursos', $valores);
    }

}
