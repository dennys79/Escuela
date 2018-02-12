<?php

require_once MODS_PATH . 'Alumno' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once 'Inasistencias.php';
require_once 'InasistenciaAlumnos.php';
require_once APP_PATH . 'Modelo.php';

/**
 * Clase Modelo Alumno que extiende de la clase Modelo
 */
class Inasistencias_Modelos_indexModelo extends App_Modelo {

    protected $_alumnos;

    /**
     * Clase constructora 
     */
    public function __construct() {
        parent::__construct();
        $this->_alumnos = new Alumno_Modelos_indexModelo();
    }

    public function comprobarTabla($table) {
        return $this->ifExistTable(PRE_TABLE . $table);
    }

    public function crearTabla($consulta) {
        return $this->_db->query($consulta);
    }

    /**
     * Obtiene un array con las inasistencias del día
     * @param string $whereInasistencias indica la fecha de las inasisencias
     * @return Resource 
     */
    public function getInasistenciasAlumnosFecha($whereInasistencias = null, $whereAlumnos = null) {
        if ($whereAlumnos == 'id_curso=') {
            $incriptos = $this->_alumnos->getAlumnosBySqlResource("Select T1.* From escuela_alumnos T1
            Inner Join escuela_inscripciones T2
            ON T1.id = T2.id_alumno Order by apellidos");
        } else {
            $incriptos = $this->_alumnos->getAlumnosBySqlResource("Select T1.* From escuela_alumnos T1
            Inner Join escuela_inscripciones T2
            ON T1.id = T2.id_alumno WHERE $whereAlumnos Order by apellidos");
        }
        $inasistenciaAlumno = array();
        if (is_array($incriptos)) {
            foreach ($incriptos as $alumno) {
                $sql = 'SELECT * FROM ' . PRE_TABLE . 'inasistencias_alumnos WHERE ' . $whereInasistencias .
                        ' AND id_alumno =' . $alumno['id'] . ' ORDER BY id';
                $this->_db->setTipoDatos('Array');
                $this->_db->query($sql);
                $inasistencias = $this->_db->fetchRow();
                $inasistenciaAlumno[] = new Inasistencias_Modelos_InasistenciaAlumnos($alumno, $inasistencias);
            }
        }
        return $inasistenciaAlumno;
    }

    /**
     * Crea un array de ciclos
     * @param Array $lista
     * @return \Alumno
     */
    public function _crearInasistencias($lista) {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = $this->_crearInasistencia($datos);
            }
        }
        return $resultado;
    }

    /**
     * Crea un objeto Inasistencia
     * @param Array $datos
     * @return \Inasistencia
     */
    public function _crearInasistencia($datos) {
        $inasistencia = new Inasistencias_Modelos_InasistenciaAlumnos($datos);
        return $inasistencia;
    }

    /**
     * Obtiene los datos de un ciclo
     * @param string $where la consulta WHERE
     * @return Resource 
     */
    public function getInasistencias($where) {
        $sql = "SELECT * FROM " . PRE_TABLE . "ciclos WHERE $where";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearInasistencias($this->_db->fetchRow());
    }
    
    public function existeInasistencia($where){
        $sql = "SELECT * FROM " . PRE_TABLE . "inasistencias_alumnos WHERE $where";
        echo $sql;
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchAll();
    }
    
    public function insertarInasistencias($valores){
        return $this->_db->insert(PRE_TABLE . 'inasistencias_alumnos', $valores);
    }
    
    public function editarInasistencias(array $valores, $condicion){
        return $this->_db->editar(PRE_TABLE . 'inasistencias_alumnos', $valores, $condicion);
    }

}
