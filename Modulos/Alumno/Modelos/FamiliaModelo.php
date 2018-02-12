<?php

//require_once BASE_PATH . 'LibQ' . DS . 'Bd' . DS . 'Sql.php';
require_once APP_PATH . 'Modelo.php';

/**
 * Clase Modelo Datos Laborales que extiende de la clase Modelo
 */
class Alumno_Modelos_familiaModelo extends App_Modelo
{

    private $_verEliminados = 0;

    /**
     * Clase constructora 
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtiene un array con los Familiares de un alumno
     * @return Resource 
     */
    public function getFamiliares($id)
    {
        $sql = "select * from " . PRE_TABLE . "familia_alumno where idAlumno = $id AND eliminado = $this->_verEliminados";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchall();
    }

    public function getFamiliar($id)
    {
        $id = (int) $id;
        $sql = "select * from " . PRE_TABLE . "familia_alumno where id = $id AND eliminado = '$this->_verEliminados'";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchRow();
    }
    

    /**
     * Guarda un contanto en la BD
     * @param array $valores
     * @return int lastInsertId 
     */
    public function insertarFamiliarAlumno(array $valores)
    {
        return $this->_db->insert(PRE_TABLE . 'familia_alumno', $valores);
    }
    
    public function eliminarFamiliarAlumno($condicion)
    {
        return $this->_db->eliminar(PRE_TABLE . 'familia_alumno', $condicion);
    }

    

}
