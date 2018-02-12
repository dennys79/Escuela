<?php

require_once 'ICiclo.php';

/**
 * Clase Ciclo
 * @author WERD
 */
abstract class Ciclo_Modelos_CicloDecorador implements Ciclo_Modelos_ICiclo {

    protected $_ciclo;

    public function __construct(Ciclo_Modelos_ICiclo $ciclo) {
        $this->_ciclo = $ciclo;
    }

    public function __call($method, $args) {
        return call_user_func_array(array($this->damage, $method), $args);
    }

}
