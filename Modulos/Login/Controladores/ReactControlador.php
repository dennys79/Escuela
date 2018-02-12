<?php

/**
 * Controlador React del sitio
 */
require_once BASE_PATH . 'Modelos' . DS . 'IndexModelo.php';
//require_once BASE_PATH;

class Login_Controladores_ReactControlador extends App_Controlador
{

    protected $_modelo;

    public function __construct()
    {
        parent::__construct();
        $this->_modelo = new Modelos_IndexModelo();
    }

    public function index()
    {
        $this->isAutenticado();
    }
    
    public function getVarSession($clave)
    {
        echo App_Session::get($clave);
    }
    
    public function getSession($clave)
    {
        $retorno = array();
        $session = App_Session::getSession($clave);
//        foreach ($session as $indice=>$valor){
//            $retorno[] = $indice . ':' . $valor;
//        }
//        echo implode(',', $retorno);
        echo json_encode($session);
    }

}
