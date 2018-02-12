<?php

/**
 * Clase Inasistencias
 * @author WERD
 */
class Inasistencias_Modelos_Inasistencias {

    protected $_id;
    protected $_fecha;
    protected $_id_alumno;
    protected $_estado;
    protected $_observaciones;

    public function __construct($inasistencia = array()) {
        $this->_id = $inasistencia['id'];
        $this->_fecha = $inasistencia['fecha'];
        $this->_id_alumno = $inasistencia['id_alumno'];
        $this->_estado = $inasistencia['estado'];
        $this->_observaciones = $inasistencia['observaciones'];
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

    public function getEstado() {
        return $this->_estado;
    }

    public function getObservaciones() {
        return $this->_observaciones;
    }
    
    public function __toString() {
        return $this->_fecha . $this->_id_alumno . $this->_estado;
    }

}
