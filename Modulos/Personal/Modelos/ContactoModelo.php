<?php

require_once APP_PATH . 'Modelo.php';

/**
 * Clase Modelo Datos Laborales que extiende de la clase Modelo
 */
class Personal_Modelos_contactoModelo extends App_Modelo
{
    protected $_table = 'contacto_personal';

    /**
     * Clase constructora 
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function insertarContacto(array $valores)
    {
        return $this->_db->insert(PRE_TABLE . 'contacto_personal', $valores);
    }

    public function editarContacto(array $valores, $condicion)
    {
        return $this->_db->editar(PRE_TABLE . $this->_table, $valores, $condicion);
    }

    public function eliminarContacto($condicion)
    {
        return $this->_db->eliminar(PRE_TABLE . $this->_table, $condicion);
    }


}