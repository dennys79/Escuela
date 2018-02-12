<?php

/**
 * Clase Ciclo
 * @author WERD
 */
class Ciclo_Modelos_Ciclo {

    protected $_id;
    protected $_ciclo;
    protected $_actual;
    protected $_observaciones;

    public function __construct($ciclo = array()) {
        $this->_id = $ciclo['id'];
        $this->_ciclo = $ciclo['ciclo'];
        $this->_actual = $ciclo['actual'];
        $this->_observaciones = $ciclo['observaciones'];
    }

    public function getId() {
        return $this->_id;
    }

    public function getCiclo() {
        return $this->_ciclo;
    }

    public function getActual() {
        return $this->_actual;
    }

    public function getObservaciones() {
        return $this->_observaciones;
    }
    
    public function __toString() {
        return $this->_ciclo;
    }

}
