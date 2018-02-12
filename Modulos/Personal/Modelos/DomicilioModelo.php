<?php

/**
 * Clase Modelo ObrasSociales que extiende de la clase Modelo
 */
class Personal_Modelos_domicilioModelo extends App_Modelo
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
        return $this->_db->insert(PRE_TABLE . 'domicilios_personal', $valores);
    }

    public function editarDomicilio(array $valores, $condicion)
    {
        return $this->_db->editar(PRE_TABLE . 'domicilios_personal', $valores, $condicion);
    }

    public function eliminarDomicilio($condicion)
    {
        return $this->_db->eliminar(PRE_TABLE . 'domicilios_personal', $condicion);
    }

}
