<?php
require_once MODS_PATH . 'BloqueInfo' . DS . 'Modelos' . DS . 'IndexModelo.php';

/**
 * Clase Ciclo Controlador 
 */
class BloqueInfo_Controladores_IndexControlador extends App_Controlador {

    protected $_infobd;
    protected $_tituloModulo;
    protected $_items = [];

    /**
     * Constructor de la clase Index
     * Inicializa los modelos 
     * @param string $mod Modulo Solicitante
     */
    public function __construct( $mod ) {
        parent::__construct();
        $this->_infobd = new BloqueInfo_Modelos_indexModelo();
    }
    
    public function setTitulo( $titulo ){
        $this->_tituloModulo = $titulo;
    }
    
    public function getTitulo(){
        return $this->_tituloModulo;
    }
    
    public function setItem($item){
        $this->_items[] = $item;
    }
    
    public function getItems(){
        return $this->_items;
    }

    public function index(){}

}
