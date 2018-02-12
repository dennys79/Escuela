<?php
require_once MODS_PATH . 'Administrator' . DS . 'Modelos' . DS . 'Iva.php';

/**
 * Modelo de la clase Iva
 *
 * @author WERD
 */

class Administrador_Modelos_IvaModelo extends App_Modelo
{
    protected $_iva;
    
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Obtiene un array con los tipos de contribuyentes iva
     * @return Array
     */
    public function getTipoContribuyentes()
    {
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'tipos_responsables_iva ORDER BY id';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearListaContribuyentes($this->_db->fetchall());
    }
    
    /**
     * Obtiene un array con los datos de un tipo de contribuyente iva
     * @return Array
     */
    public function getTipoContribuyente($where)
    {
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'tipos_responsables_iva WHERE ' . $where . ' ORDER BY id';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearTipoContribuyente($this->_db->fetchrow());
    }
    
    private function _crearListaContribuyentes($datos)
    {
        $lista = array();
        foreach ($datos as $value) {
            $lista[] = $this->_crearTipoContribuyente($value);
        }
        return $lista;
    }
    
    private function _crearTipoContribuyente($datos)
    {
        return new Administrator_Modelos_Iva($datos);
    }
    
    public function editarIva($id, $contribuyente)
    {
        $sql = "UPDATE " . PRE_TABLE . "tipos_responsables_iva "
                . "SET contribuyente = '$contribuyente' WHERE id = $id";
        return $this->_db->query($sql);
    }
    
    public function nuevoIva($contribuyente)
    {
        $sql = "INSERT INTO " . PRE_TABLE . "tipos_responsables_iva "
                . "(contribuyente) VALUES ('$contribuyente')";
        return $this->_db->query($sql);
    }
    
    public function eliminarIva($condicion)
    {
        return $this->_db->eliminar(PRE_TABLE . 'tipos_responsables_iva', $condicion);
    }
   
    
    
}
