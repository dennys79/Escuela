<?php

class Modelos_registroModelo extends App_Modelo
{
    public function __construct()
    {
        parent::__construct();
    }
        
    public function nuevoEvento($datos)
    {
        $this->_db->insert(PRE_TABLE . 'registro', $datos);
    }
    
}