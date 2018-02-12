<?php
//require_once MODS_PATH . 'Personal' . DS . 'Modelos' . DS . 'Personal.php';
require_once 'Ciclo.php';
require_once APP_PATH . 'Modelo.php';


/**
 * Clase Modelo Alumno que extiende de la clase Modelo
 */
class Ciclo_Modelos_indexModelo extends App_Modelo
{

    private $_verEliminados = 0;

    /**
     * Clase constructora 
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    public function comprobarTabla($table)
    {
        return $this->ifExistTable(PRE_TABLE . $table);
    }
    
    public function crearTabla($consulta)
    {
        return $this->_db->query($consulta);
    }

    /**
     * Obtiene un array con los ciclos
     * @return Resource 
     */
    public function getCiclos()
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'ciclos ORDER BY ciclo';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearCiclos($this->_db->fetchall());
    }

    /**
     * Crea un array de ciclos
     * @param Array $lista
     * @return \Alumno
     */
    public function _crearCiclos($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = $this->_crearCiclo($datos);
            }
        }
        return $resultado;
    }

    /**
     * Crea un ciclo
     * @param Array $datos
     * @return \Alumno
     */
    public function _crearCiclo($datos)
    {
        $ciclo = new Ciclo_Modelos_Ciclo($datos);
        return $ciclo;
    }
    
    /**
     * Obtiene los datos de un ciclo
     * @param string $where la consulta WHERE
     * @return Resource 
     */
    public function getCiclo($where)
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "ciclos WHERE $where";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearCiclo($this->_db->fetchRow());
    }

    /**
     * Obtiene los datos de el ciclo actual
     * @return Resource 
     */
    public function getCicloActual()
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "ciclos WHERE actual = 1";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearCiclo($this->_db->fetchRow());
    }
    
    /**
     * Verifica que exista un ciclo
     * @param $where parametro de consulta
     * @return boolean
     */
    public function existeCiclo($where)
    {
        $retorno = false;
        $sql = "SELECT * FROM " . PRE_TABLE . "ciclos WHERE $where";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        if($this->_db->fetchRow()){
            $retorno = true;
        }
        return $retorno;
    }
    
    public function insertarCiclo(array $valores)
    {
        return $this->_db->insert(PRE_TABLE . 'ciclos', $valores);
    }

    public function editarCiclo(array $valores, $condicion)
    {
        return $this->_db->editar(PRE_TABLE . 'ciclos', $valores, $condicion);
    }
    
    public function eliminarCiclo($condicion)
    {
        return $this->_db->eliminar(PRE_TABLE . 'ciclos', $condicion);
    }
}
