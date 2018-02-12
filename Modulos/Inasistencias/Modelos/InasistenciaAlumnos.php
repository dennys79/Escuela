<?php

/**
 * Clase Inasistencias
 * @author WERD
 */
class Inasistencias_Modelos_InasistenciaAlumnos extends Alumno_Modelos_Alumno {

    protected $_id;
    protected $_fecha;
    protected $_id_alumno;
    protected $_valor;
    protected $_observaciones;

    public function __construct($alumno = array(), $inasistencia) {
        parent::__construct($alumno);
        if (!is_bool($inasistencia)) {
            $this->_id = $inasistencia['id'];
            $this->_fecha = $inasistencia['fecha'];
            $this->_id_alumno = $inasistencia['id_alumno'];
            $this->_valor = $inasistencia['valor'];
            $this->_observaciones = $inasistencia['observaciones'];
        }
    }

    public function getId() {
        return $this->_id;
    }

    public function getFecha() {
        return $this->_fecha;
    }

    public function getId_alumno() {
        return $this->_id_alumno;
    }

    public function getValor() {
        return $this->_valor;
    }

    public function getObservaciones() {
        return $this->_observaciones;
    }

    public function __toString() {
        return $this->_fecha . $this->_id_alumno . $this->_valor;
    }

}
