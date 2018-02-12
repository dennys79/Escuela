<?php

class App_Modelo
{
    protected $_db;
    
    public function __construct()
    {
        $this->_db = new App_DataBase();
    }
    
    /**
     * Verifica que la tabla exista
     * Devuelve false si no existe
     * @param strin $table
     * @return boolean
     */
    public function ifExistTable($table)
    {
        $retorno = TRUE;
        $sql = "SELECT * FROM $table";
        try{
            $this->_db->query($sql);
        } catch (Exception $e){
            $retorno = FALSE;
        }
        return $retorno;
    }
}