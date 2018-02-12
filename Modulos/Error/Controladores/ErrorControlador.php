<?php

/**
 * Controlador de los Errores
 *
 * @author WERD
 */
class Error_Controladores_errorControlador extends App_Controlador
{
    public function __construct(){
        parent::__construct();
    }
    
    public function index()
    {
        $this->isAutenticado();
        $this->_vista->titulo = TITULO_ERROR;
        $this->_vista->msg = '';
        $this->_vista->renderizar('index');
    }
    
    public function e5050()
    {
        $this->isAutenticado();
        $this->_vista->titulo = TITULO_ERROR;
        $this->_vista->msg = MSG_5050;
        $this->_vista->renderizar('index');
    }
    
    public function e8080()
    {
        $this->isAutenticado();
        $this->_vista->titulo = TITULO_ERROR;
        $this->_vista->msg = MSG_8080;
        $this->_vista->renderizar('index');
    }
}
