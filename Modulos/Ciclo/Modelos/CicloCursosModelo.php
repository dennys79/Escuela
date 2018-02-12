<?php
//require_once MODS_PATH . 'Personal' . DS . 'Modelos' . DS . 'Personal.php';
require_once 'Ciclo.php';
require_once APP_PATH . 'Modelo.php';


/**
 * Clase Modelo Alumno que extiende de la clase Modelo
 */
class Ciclo_Modelos_CicloCursosModelo extends App_Modelo
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
     * Obtiene un array con los ciclos y los cursos correspondientes
     * @return Resource 
     */
    public function getCicloCursos()
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'ciclo_cursos ORDER BY id_ciclo';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearCiclosCursos($this->_db->fetchall());
    }

    /**
     * Crea un array de ciclos
     * @param Array $lista
     * @return \Alumno
     */
    public function _crearCiclosCursos($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = $this->_crearCicloCursos($datos);
            }
        }
        return $resultado;
    }

    /**
     * Crea un ciclo
     * @param Array $datos
     * @return \Alumno
     */
    public function _crearCicloCursos($datos)
    {
        $ciclo = new Ciclo_Modelos_Ciclo($datos);
        return $ciclo;
    }
    
    public function insertarCicloCurso(array $valores)
    {
        return $this->_db->insert(PRE_TABLE . 'ciclo_cursos', $valores);
    }

    public function editarCicloCursos(array $valores, $condicion)
    {
        return $this->_db->editar(PRE_TABLE . 'ciclo_cursos', $valores, $condicion);
    }
    
    public function eliminarCicloCurso($condicion)
    {
        return $this->_db->eliminar(PRE_TABLE . 'ciclo_cursos', $condicion);
    }
    
   
}
