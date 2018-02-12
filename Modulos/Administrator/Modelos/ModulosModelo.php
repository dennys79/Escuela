<?php
require_once MODS_PATH . 'Administrator' . DS . 'Modelos' . DS . 'Modulo.php';

/**
 * Modelo de la clase modulos
 *
 * @author WERD
 */

class Administrator_Modelos_ModulosModelo extends App_Modelo
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Obtiene un array con los modulos de la Aplicacion
     * @return Resource 
     */
    public function getAllModulos()
    {
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'modulos ORDER BY id';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearModulos($this->_db->fetchall());
    }
    
    /**
     * Obtiene un modulos de la Aplicacion
     * @return Resource 
     */
    public function getModulo($where)
    {
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'modulos WHERE ' . $where;
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearModulo($this->_db->fetchRow());
    }
    
    /**
     * Obtiene un array con los modulos habilitados de la Aplicacion
     * @return Resource 
     */
    public function getModulosHabilitados()
    {
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'modulos WHERE habilitado = 1 ORDER BY id';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearModulos($this->_db->fetchall());
    }
    
    /**
     * Obtiene un array con los modulos visibles de la Aplicacion
     * @return Resource 
     */
    public function getModulosVisibles()
    {
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'modulos WHERE visible = 1 ORDER BY id';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearModulos($this->_db->fetchall());
    }
    
    /**
     * Devuelve false si el nombre del módulo no existe en la bd
     * @param String $modulo
     * @return boolean $valor
     */
    public function ifExistModulo($modulo)
    {
        $sql = "SELECT modulo FROM " . PRE_TABLE . "modulos WHERE modulo = '" . $modulo . "'";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $retorno = $this->_db->fetchRow();
        if ($retorno){
            $valor = true;
        }else{
            $valor = false;
        }
        return $valor;
    }
    
    /**
     * Crea un array de modulos de la aplicacion
     * @param Array $lista
     * @return Array
     */
    public function _crearModulos($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = $this->_crearModulo($datos);
            }
        }
        return $resultado;
    }
    
    /**
     * Crea un modulo
     * @param Array $datos
     * @return Modulo
     */
    public function _crearModulo($datos)
    {
        $modulo = new Modulos_Modelos_Modulo($datos);
        return $modulo;
    }
    
    public function editarModulo($condicion, $datos)
    {
        return $this->_db->editar(PRE_TABLE . 'modulos', $datos, $condicion);
    }
    
    public function insertarModulo($datos)
    {
        return $this->_db->insert(PRE_TABLE . 'modulos', $datos);
    }
    
    public function eliminarModulo($condicion)
    {
        return $this->_db->eliminar(PRE_TABLE . 'modulos', $condicion);
    }
}
