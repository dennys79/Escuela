<?php

//require_once BASE_PATH . 'LibQ' . DS . 'Bd' . DS . 'Sql.php';
require_once APP_PATH . 'Modelo.php';

/**
 * Clase Modelo Datos Laborales que extiende de la clase Modelo
 */
class Alumno_Modelos_saludModelo extends App_Modelo
{


    /**
     * Clase constructora 
     */
    public function __construct()
    {
        parent::__construct();
    } 

    /**
     * Guarda un contanto en la BD
     * @param array $valores
     * @return int lastInsertId 
     */
    public function insertarSalud(array $valores)
    {
        return $this->_db->insert(PRE_TABLE . 'salud_alumnos', $valores);
    }
    
    public function editarSalud(array $valores, $condicion)
    {
        return $this->_db->editar(PRE_TABLE . 'salud_alumnos', $valores, $condicion);
    }

        public function eliminarSaludAlumno($condicion)
    {
        return $this->_db->eliminar(PRE_TABLE . 'salud_alumnos', $condicion);
    }
    
    public function getDiagnosticos()
    {
        $sql = "SELECT diagnostico FROM " . PRE_TABLE . "diagnosticos";
        $this->_db->query($sql);
        return $this->_db->fetchAll();
    }

    public function insertarDiagnostico(array $valores)
    {
        return $this->_db->insert(PRE_TABLE . 'diagnosticos', $valores);
    }
    
    public function existeDiagnostico($diag)
    {
        $sql = "SELECT diagnostico FROM " . PRE_TABLE . "diagnosticos WHERE diagnostico='".$diag."'";
        $this->_db->query($sql);
        return count($this->_db->fetchRow());
    }

}
