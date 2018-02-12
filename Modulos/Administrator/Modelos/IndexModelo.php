<?php
require_once APP_PATH . 'Modelo.php';
require_once 'IvaModelo.php';
require_once 'PuestoTrabajoModelo.php';
require_once 'ModulosModelo.php';

class Administrator_Modelos_indexModelo extends App_Modelo
{
    protected $_ivaModelo;
    protected $_puestos;
    protected $_modulos;

    public function __construct()
    {
        parent::__construct();
        $this->_ivaModelo = new Administrador_Modelos_IvaModelo();
        $this->_puestos = new Administrador_Modelos_PuestoTrabajoModelo();
        $this->_modulos = new Administrator_Modelos_ModulosModelo();
    }
    
    public function getTipoContribuyentes()
    {
        return $this->_ivaModelo->getTipoContribuyentes();
    }
    
    public function getTipoContribuyente($where)
    {
        return $this->_ivaModelo->getTipoContribuyente($where);
    }
    
    public function getModulo($where)
    {
        return $this->_modulos->getModulo($where);
    }
    
    public function getPuestos()
    {
        return $this->_puestos->getPuestos();
    }
    
    public function getPuesto($id)
    {
        return $this->_puestos->getPuesto("id=".$id);
    }
    
    public function getAllModulos()
    {
        return $this->_modulos->getAllModulos();
    }
    
    public function editarIva($id, $contribuyente)
    {
        return $this->_ivaModelo->editarIva($id, $contribuyente);
    }
    
    public function editarModulo($condicion, $datos)
    {
        return $this->_modulos->editarModulo($condicion, $datos);
    }
    
    public function editarPuesto($condicion, $datos)
    {
        return $this->_puestos->editarPuesto($condicion, $datos);
    }
    
    public function nuevoIva($contribuyente)
    {
        return $this->_ivaModelo->nuevoIva($contribuyente);
    }
    
    public function nuevoPuesto($puesto)
    {
        return $this->_puestos->nuevoPuesto($puesto);
    }
    
    public function insertarModulo($datos)
    {
        return $this->_modulos->insertarModulo($datos);
    }
    
    public function eliminarIva($where)
    {
        return $this->_ivaModelo->eliminarIva($where);
    }
    
    public function eliminarModulo($where)
    {
        return $this->_modulos->eliminarModulo($where);
    }
    
    public function eliminarPuesto($where)
    {
        return $this->_db->eliminar(PRE_TABLE . 'puestos', $where);
    }

}

