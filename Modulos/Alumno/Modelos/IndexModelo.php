<?php
//require_once MODS_PATH . 'Personal' . DS . 'Modelos' . DS . 'Personal.php';
//require_once MODS_PATH . 'ObrasSociales' . DS . 'Modelos' . DS . 'ObraSocial.php';
require_once APP_PATH . 'Modelo.php';
require_once 'Alumno.php';
require_once 'ContactoAlumno.php';
require_once 'DomicilioAlumno.php';
require_once 'SaludAlumno.php';
//require_once MODS_PATH . 'Terapias' . DS . 'Modelos' . DS . 'Terapia.php';

/**
 * Clase Modelo Alumno que extiende de la clase Modelo
 */
class Alumno_Modelos_indexModelo extends App_Modelo
{

    private $_verEliminados = 0;
    private $_lastId;

    /**
     * Clase constructora 
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Obtiene un array con los alumnos
     * @return Resource 
     */
    public function getAlumnos()
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'alumnos WHERE eliminado = ' .
                $this->_verEliminados . ' ORDER BY apellidos';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearAlumnos($this->_db->fetchall());
    }
    
    /**
     * Obtiene un array con los alumnos
     * @return Resource 
     */
    public function getAlumnosRegulares()
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'alumnos WHERE estado = "regular" ORDER BY apellidos';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearAlumnos($this->_db->fetchall());
    }
    
    
    /**
     * Obtiene un array con los alumnos
     * @return Resource 
     */
    public function getListaEscuelas()
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'lista_escuelas ORDER BY Nombre';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchall();
    }

    /**
     * Crea un array de alumnos
     * @param Array $lista
     * @return \Alumno
     */
    public function _crearAlumnos($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = $this->_crearAlumno($datos);
            }
        }
        return $resultado;
    }

    /**
     * Crea un alumno
     * @param Array $datos
     * @return \Alumno
     */
    public function _crearAlumno($datos)
    {
        $pac = new Alumno_Modelos_Alumno($datos);
        $pac->setDomicilio($this->getDomicilioAlumno("id_alumno=" . $datos['id']));
        $pac->setContactos($this->getContactosAlumno("id_alumno=" . $datos['id']));
        $pac->setObjFamilia($this->getFamiliaAlumno("id_alumno=" . $datos['id']));
        $pac->setObjSalud($this->getSaludAlumno("id_alumno=" . $datos['id']));
        return $pac;
    }
    
    public function getFamiliaAlumno($where)
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'familia_alumno WHERE eliminado = ' .
                $this->_verEliminados . ' AND ' . $where;
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearFamiliaAlumno($this->_db->fetchAll());
    }
    
    public function _crearFamiliaAlumno($lista)
    {
        require_once 'FamiliaAlumno.php';
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = new FamiliaAlumno($datos);
            }
        }
        return $resultado;
    }
    
    public function getEducacionAlumno($where)
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'educacion_alumno WHERE eliminado = ' .
                $this->_verEliminados . ' AND ' . $where;
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearEducacionAlumno($this->_db->fetchRow());
    }

    public function _crearEducacionAlumno($datos)
    {
        require_once 'EducacionAlumno.php';
        $resultado = new EducacionAlumno($datos);
        return $resultado;
    }

    /**
     * Obtener de la bd los domicilios del alumno solicitado en el $where
     * @param String $where
     * @return Array
     */
    public function getDomicilioAlumno($where)
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'domicilios_alumnos WHERE eliminado = ' .
                $this->_verEliminados . ' AND ' . $where . ' ORDER BY tipo_domicilio';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearDomicilio($this->_db->fetchRow());
    }

    public function _crearDomicilios($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = new DomicilioAlumno($datos);
            }
        }
        return $resultado;
    }
    
    public function _crearDomicilio($datos)
    {
        return new DomicilioAlumno($datos);
    }

    /**
     * Obtiene un array con los alumnos
     * @return Resource 
     */
    public function getAlumnosArray($consulta='')
    {
        if ($consulta==''){
            $sql = 'SELECT * FROM ' . PRE_TABLE . 'alumnos ORDER BY apellidos';
        } else {
            $sql = 'SELECT * FROM ' . PRE_TABLE . 'alumnos WHERE '. $consulta. ' ORDER BY apellidos';
        }
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchall();
    }
    
    /**
     * Obtiene un array con los alumnos de una OS
     * @return Resource 
     */
    public function getAlumnosByOs($idOsocial)
    {
        $sql = 'SELECT osAlumno.id, osAlumno.idAlumno, osAlumno.idOSocial,
            osAlumno.nro_afiliado, osAlumno.pacos_observaciones, alumnos.* 
            FROM ' . PRE_TABLE . 'alumno_os as osAlumno, ' . PRE_TABLE . 'alumnos as alumnos 
            WHERE osAlumno.idOSocial = ' . $idOsocial .
                ' AND osAlumno.idAlumno = alumnos.id AND alumnos.eliminado = ' .
                $this->_verEliminados . ' ORDER BY alumnos.apellidos, alumnos.nombres';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
//        echo '<pre>';
//        var_dump($this->_db->fetchall());
        return $this->_crearAlumnos($this->_db->fetchall());
    }

    /**
     * Obtiene algunos alumnos
     * @return Resource 
     */
    public function getAlgunosAlumnos($inicio, $fin, $orden, $filtro, $campos = array('*'))
    {
        $this->_verEliminados = 0;
        $sql = new Sql();
        $sql->addCampos($campos);
        $sql->addFuncion('Select');
        $sql->addTable(PRE_TABLE . 'alumnos AS alumnos');
        $sql->addOrder($orden);
        $sql->addWhere("alumnos.eliminado=$this->_verEliminados");
        if ($filtro != '') {
            $sql->addWhere($filtro);
        }

        if ($fin > 0) {
            $sql->addLimit($inicio, $fin);
        }
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return Alumno::getAlumnos($this->_db->fetchall());
    }

    public function getAlumnosBySql($sql)
    {
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearAlumnos($this->_db->fetchall());
    }
    
    public function getAlumnosBySexo($sexo)
    {
        $this->_db->setTipoDatos('Array');
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'alumnos WHERE sexo="'.$sexo.'"';
        $this->_db->query($sql);
        return $this->_crearAlumnos($this->_db->fetchall());
    }
    
    public function getAlumnosBySqlResource($sql)
    {
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchall();
    }

    /**
     * Obtiene los datos de un alumno
     * @param string $where
     * @return Resource 
     */
    public function getAlumno($where)
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "alumnos WHERE $where";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearAlumno($this->_db->fetchRow());
    }
    
    /**
     * Verifica que exista un alumno
     * @param $where parametro de consulta
     * @return boolean
     */
    public function existeAlumno($where)
    {
        $retorno = false;
        $sql = "SELECT * FROM " . PRE_TABLE . "alumnos WHERE $where";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        if($this->_db->fetchRow()){
            $retorno = true;
        }
        return $retorno;
    }
    
    public function getTerpias()
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "terapias";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearTerapias($this->_db->fetchall());
    }
    
    public function getTerpiasAlumno($where)
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "alumnos_terapia WHERE $where ";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearTerapiasAlumno($this->_db->fetchall());
    }
    
    public function getSaludAlumno($where)
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "salud_alumnos WHERE $where ";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearSaludAlumno($this->_db->fetchRow());
    }

    public function insertarAlumno(array $valores)
    {
        return $this->_db->insert(PRE_TABLE . 'alumnos', $valores);
    }
    
    public function insertarDomicilioAlumno(array $valores)
    {
        return $this->_db->insert(PRE_TABLE . 'domicilios_alumnos', $valores);
    }
    
    public function modificarDomicilioAlumno(array $valores,$condicion)
    {
        return $this->_db->editar(PRE_TABLE . 'domicilios_alumnos', $valores, $condicion);
    }
    
    public function insertarDiagnosticoAlumno(array $valores)
    {
        return $this->_db->insert(PRE_TABLE . 'diagnosticos_alumnos', $valores);
    }

    public function editarAlumno(array $valores, $condicion)
    {
        return $this->_db->editar(PRE_TABLE . 'alumnos', $valores, $condicion);
    }
        
    public function editarDiagnosticoAlumno(array $valores, $condicion)
    {
        return $this->_db->editar(PRE_TABLE . 'diagnosticos_alumnos', $valores, $condicion);
    }

    public function eliminarAlumno($condicion)
    {
        return $this->_db->eliminar(PRE_TABLE . 'alumnos', $condicion);
    }

    /**
     * Obtiene algunos personal
     * @return Resource 
     */
    public function getAlgunosPersonal($inicio, $fin, $orden, $filtro, $campos = array('*'))
    {
        $this->_verEliminados = 0;
        $sql = new Sql();
        $sql->addCampos($campos);
        $sql->addFuncion('Select');
        $sql->addTable(PRE_TABLE . 'personal AS personal');
        $sql->addOrder($orden);
        $sql->addWhere("personal.eliminado=$this->_verEliminados");
        if ($filtro != '') {
            $sql->addWhere($filtro);
        }

        if ($fin > 0) {
            $sql->addLimit($inicio, $fin);
        }
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchall();
    }

    public function getContactosAlumnos()
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'contacto_alumnos WHERE eliminado = ' .
                $this->_verEliminados . ' ORDER BY tipo';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearContactos($this->_db->fetchall());
    }

    public function getContactosAlumno($where)
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'contacto_alumnos WHERE eliminado = ' .
                $this->_verEliminados . ' AND ' . $where . ' ORDER BY tipoContacto';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearContactos($this->_db->fetchall());
    }
    
    public function getOSocialAlumno($where)
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'alumno_os WHERE eliminado = ' .
                $this->_verEliminados . ' AND ' . $where . ' ORDER BY id';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $datosOSocial = $this->_db->fetchRow();
//        return $this->_crearOSocial('id = ' . $datosOSocial['idOSocial']);
        return $datosOSocial;
    }
    
    private function _crearOSocial($where)
    {
        require_once MODS_PATH . 'ObrasSociales' . DS . 'Modelos' . DS . 'IndexModelo.php';
        $os = new ObrasSociales_Modelos_indexModelo();
        $os->getObraSocial($where);
        return $os;
    }

    private function _crearContactos($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = new ContactoAlumno($datos);
            }
        }
        return $resultado;
    }
    
    private function _crearTerapias($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = new Terapias_Modelos_Terapia($datos);
            }
        }
        return $resultado;
    }
        
    
    private function _crearSaludAlumno($lista)
    {
        $resultado = new Alumnos_Modelos_SaludAlumno($lista);
        return $resultado;
    }    
    
    
    /**
     * Obtiene una lista de nacionalidades
     * @param string $where
     * @return Resource 
     */
    public function getNacionalidadesAlumnos()
    {
        $sql = "SELECT DISTINCT nacionalidad FROM " . PRE_TABLE . "alumnos";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchAll();
    }
    
    /**
     * Obtiene una lista de diagnosticos
     * @param string $where
     * @return Resource 
     */
    public function getDiagnosticosAlumnos()
    {
        $sql = "SELECT DISTINCT diagnostico FROM " . PRE_TABLE . "salud_alumnos";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchAll();
    }

}
