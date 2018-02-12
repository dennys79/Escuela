<?php

/**
 * Clase Modelo ObrasSociales que extiende de la clase Modelo
 */
class Alumno_Modelos_domicilioModelo extends App_Modelo
{

    /**
     * Clase constructora 
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function insertarDomicilio(array $valores)
    {
        return $this->_db->insert('escuela_domicilios_alumnos', $valores);
    }

    public function editarDomicilio(array $valores, $condicion)
    {
        return $this->_db->editar('escuela_domicilios_alumnos', $valores, $condicion);
    }

    public function eliminarDomicilio($condicion)
    {
        return $this->_db->eliminar('escuela_domicilios_alumnos', $condicion);
    }

}
