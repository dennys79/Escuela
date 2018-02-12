<?php
require_once MODS_PATH . 'Administrator' . DS . 'Modelos' . DS . 'PuestoTrabajo.php';

/**
 * Modelo de la clase Iva
 *
 * @author WERD
 */

class Administrador_Modelos_PuestoTrabajoModelo extends App_Modelo
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Obtiene un array con los puestos
     * @return Array
     */
    public function getPuestos()
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "puestos";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearPuestos($this->_db->fetchall());
    }
    
    /**
     * Obtiene un array con datos de un puesto
     * @return Array
     */
    public function getPuesto($where)
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "puestos WHERE " . $where;
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return new Administrador_Modelos_PuestoTrabajo(($this->_db->fetchRow()));
    }
    
    private function _crearPuestos($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = new Administrador_Modelos_PuestoTrabajo($datos);
            }
        }
        return $resultado;
    }
    
    public function nuevoPuesto($puesto)
    {
        return $this->_db->insert(PRE_TABLE . 'puestos', array('puesto'=>$puesto));
    }
    
    public function editarPuesto($condicion, $datos)
    {
        return $this->_db->editar(PRE_TABLE . 'puestos', $datos, $condicion);
    }
    
    
}
