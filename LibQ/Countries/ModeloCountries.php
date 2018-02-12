<?php
require_once APP_PATH . 'Modelo.php';
require_once 'Country.php';
/**
 * Modelo de la clase Countries
 *
 * @author werd
 */
class LibQ_Countries_ModeloCountries extends App_Modelo{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtiene un array con los alumnos
     * @return Resource 
     */
    public function getCountries()
    {
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'countries ORDER BY code';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearCountries($this->_db->fetchall());
    }
    
    /**
     * Crea un array de paises
     * @param Array $lista
     * @return \LibQ_Countries_Countries
     */
    public function _crearCountries($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = $this->_crearCountry($datos);
            }
        }
        return $resultado;
    }

    /**
     * Crea un alumno
     * @param Array $datos
     * @return \Alumno
     */
    public function _crearCountry($datos)
    {
        $pac = new LibQ_Contries_Country($datos);
        return $pac;
    }
    
}
