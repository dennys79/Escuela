<?php

/**
 * Clase Modulo
 * Instancia un ojeto modulo por cada modulo instalado en la aplicación
 *
 * @author WERD
 */

class Modulos_Modelos_Modulo
{
    private $_id;
    
    /**
     * El nomre del módulo
     * @var string
     */
    private $_modulo;
    
    /**
     * Indica si el modulo está habilitado
     * @var boolean
     */
    private $_habilitado;
    
    /**
     * Indica que tipo de modulo es ej. Sistema, App
     * @var string
     */
    private $_tipo;
    
    /**
     * Indica si el módulo es visible
     * @var boolean
     */
    private $_visible;


    public function __construct($datos=NULL)
    {
        $this->_id = $datos['id'];
        $this->_modulo = $datos['modulo'];
        $this->_tipo = $datos['tipo'];
        $this->_habilitado = $datos['habilitado'];
        $this->_visible = $datos['visible'];
    }
    
    public function getId()
    {
        return $this->_id;
    }

    public function getModulo()
    {
        return $this->_modulo;
    }
    
    public function getTipo()
    {
        return $this->_tipo;
    }

    public function getHabilitado()
    {
        return $this->_habilitado;
    }
    
    public function getVisible()
    {
        return $this->_visible;
    }

    public function __toString()
    {
        return $this->_modulo;
    }
    
    
}
