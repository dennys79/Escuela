<?php

/**
 * Clase Modulo
 * Instancia un ojeto modulo por cada modulo instalado en la aplicación
 *
 * @author WERD
 */

class Administrator_Modelos_Iva
{
    protected $_id;
    protected $_contribuyente;

    public function __construct($datos=NULL)
    {
        $this->_id = $datos['id'];
        $this->_contribuyente = $datos['contribuyente'];
    }
    
    public function getId()
    {
        return $this->_id;
    }

    public function getContribuyente()
    {
        return $this->_contribuyente;
    }
    
        public function __toString()
    {
        return $this->_contribuyente;
    }
}
