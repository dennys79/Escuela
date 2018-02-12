<?php

/**
 * Clase que maneja la lista de paises
 *
 * @author werd
 */
class LibQ_Contries_Country {
    protected $_code;
    protected $_flag;
    protected $_country;
    
    public function __construct($datos) {
        $this->_code = $datos['code'];
        $this->_flag = $datos['flag'];
        $this->_country = $datos['country_iso'];
    }
    
    public function getCode()
    {
        return $this->_code;
    }
    
    public function getFlag()
    {
        return $this->_flag;
    }
    
    public function getCountry()
    {
        return $this->_country;
    }
}
