<?php

require_once BASE_PATH . 'LibQ' . DS . 'Url.php';

Class App_Request
{

    private $_modulo;
    private $_controlador;
    private $_metodo;
    private $_argumentos;

    public function __construct()
    {
        $url = new LibQ_Url(LibQ_Url::obtenerURL());
        if (isset($url)) {
            $this->_setModulo($url); //Establezco el módulo de acuerdo a la url
            $this->_setControlador($url);
            $this->_setMetodo($url);
            $this->_setArgumentos($url);
        }
//        if (!$this->_metodo) {
//            $this->_metodo = 'index';
//        }
//        if (!isset($this->_argumentos)) {
//            $this->_argumentos = array();
//        }
    }


//    private function _urlToArray()
//    {
//        $urlToArray = explode('&', trim($_SERVER['QUERY_STRING'], '?'));
//        $urlArray = array_filter($urlToArray);
//        return $urlArray;
//    }

    private function _setModulo($url)
    {
        $urlArray = $url->getQueryAsArray();
        if (isset($urlArray['mod'])) {
            $this->_modulo = ($urlArray['mod']);
        }
        if (!$this->_modulo) {
            $this->_modulo = false;
        }
    }

    private function _setControlador($url)
    {
        $urlArray = $url->getQueryAsArray();
        if (isset($urlArray['cont'])) {
            $this->_controlador = ($urlArray['cont']);
        }
        if (!$this->_controlador) {
            $this->_controlador = DEFAULT_CONTROLADOR;
        }
    }

    private function _setMetodo($url)
    {
        $urlArray = $url->getQueryAsArray();
        if (isset($urlArray['met'])) {
            $this->_metodo = ($urlArray['met']);
        }
        if (!$this->_metodo) {
            $this->_metodo = 'index';
        }
    }

    private function _setArgumentos($url)
    {
        $urlArray = $url->getQueryAsArray();
        $arg = array_slice($urlArray,3);
//        foreach ($urlArray as $key => $value) {
            if (isset($arg)) {
                $this->_argumentos = $arg;
            }
//        }
    }

    public function getModulo()
    {
        return $this->_modulo;
    }

    public function getControlador()
    {
        return $this->_controlador;
    }

    public function getMetodo()
    {
        return $this->_metodo;
    }

    public function getArgumentos()
    {
        return $this->_argumentos;
    }

}
