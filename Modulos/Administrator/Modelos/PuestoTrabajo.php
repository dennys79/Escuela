<?php

/**
 * Clase PuestodeTrabajo
 *
 * @author WERD
 */
class Administrador_Modelos_PuestoTrabajo
{
    protected $_id;
    protected $_puesto;
    
    public function __construct($datos)
    {
        $this->_id = $datos['id'];
        if (isset($datos['puesto'])){
            $this->_puesto = $datos['puesto'];
        }
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function getPuesto()
    {
        return $this->_puesto;
    }
}
