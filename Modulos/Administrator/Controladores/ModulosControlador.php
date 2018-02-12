<?php
require_once MODS_PATH . 'Administrator' . DS . 'Modelos' . DS . 'ModulosModelo.php';
/**
 * Clase controladora de los módulos de la Aplicación
 *
 * @author WERD
 */
class Administrador_ModulosControlador
{
    private $_bd;


    public function __construct()
    {
        $this->_bd = new Administrator_Modelos_ModulosModelo();
    }
    
    public function getAllModulos()
    {
        return $this->_bd->getAllModulos;
    }
    
    public function getModulosHabilitados()
    {
        return $this->_bd->getModulosHabilitados();
    }
    
    public function getModulosVisibles()
    {
        return $this->_bd->getModulosVisibles();
    }
    
    public function ifExistModulo($modulo)
    {
        return $this->_bd->ifExistModulo($modulo);
    }
}
