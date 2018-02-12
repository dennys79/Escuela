<?php
require_once MODS_PATH . 'Administrator' . DS . 'Modelos' . DS . 'IvaModelo.php';
/**
 * Clase controladora de IVA de la Aplicación
 *
 * @author WERD
 */
class Administrador_IvaControlador
{
    private $_bd;


    public function __construct()
    {
        $this->_bd = new Modelos_IvaModelo();
    }
    
    public function getTipoContribuyentes()
    {
        return $this->_bd->getTipoContribuyentes();
    }
    
    
}
