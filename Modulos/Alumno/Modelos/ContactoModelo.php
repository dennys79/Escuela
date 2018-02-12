<?php

/**
 * Clase Modelo ObrasSociales que extiende de la clase Modelo
 */
class Alumno_Modelos_contactoModelo extends App_Modelo
{
    protected $_table = 'escuela_contacto_alumnos';

    /**
     * Clase constructora 
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function insertarContacto(array $valores)
    {
        return $this->_db->insert($this->_table, $valores);
    }

    public function editarContacto(array $valores, $condicion)
    {
        return $this->_db->editar($this->_table, $valores, $condicion);
    }

    public function eliminarContacto($condicion)
    {
        return $this->_db->eliminar($this->_table, $condicion);
    }

}
