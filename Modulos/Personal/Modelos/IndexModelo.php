<?php

require_once APP_PATH . 'Modelo.php';
require_once 'Personal.php';
require_once 'DomicilioPersonal.php';
require_once 'ContactoPersonal.php';
require_once 'DatosLaboralesPersonal.php';
//require_once MODS_PATH . 'Terapias' . DS . 'Modelos' . DS . 'Terapia.php';
/**
 * Clase Modelo Personal que extiende de la clase Modelo
 */
class Personal_Modelos_indexModelo extends App_Modelo
{

    private $_verEliminados = false;

    /**
     * Clase constructora 
     */
    public function __construct()
    {
        parent::__construct();
        $this->_verEliminados = 0;
    }

    /**
     * Obtiene un array con los personal
     * @return Resource 
     */
    public function getTodoPersonal()
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "personal 
            where eliminado = $this->_verEliminados ORDER BY apellidos, nombres";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearListaPersonal($this->_db->fetchall());
    }
    
    /**
     * Crea un array de personal
     * @param Array $lista
     * @return \Personal
     */
    public function _crearListaPersonal($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = $this->_crearPersonal($datos);
            }
        }
        return $resultado;
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
        $sql->addWhere(PRE_TABLE . "personal.eliminado=$this->_verEliminados");
        if ($filtro != '') {
            $sql->addWhere($filtro);
        }

        if ($fin > 0) {
            $sql->addLimit($inicio, $fin);
        }
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearListaPersonal($this->_db->fetchall());
    }

    public function getPersonal($where)
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "personal WHERE $where";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearPersonal($this->_db->fetchRow());
    }
    
    public function getAllOcupaciones()
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "puestos";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearOcupaciones($this->_db->fetchall());
    }
    
    private function _crearOcupaciones($lista)
    {
        require_once MODS_PATH . 'Administrator' . DS . 'Modelos' . DS . 'PuestoTrabajo.php';
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = new Administrador_Modelos_PuestoTrabajo($datos);
            }
        }
        return $resultado;
    }
    
    private function _crearPersonal($datos)
    {
        $personal = new Personal_Modelos_Personal($datos);
        $personal->setDomicilio($this->getDomicilioPersonal("id_personal=" . $datos['id']));
        $personal->setContactos($this->getContactosPersonal("id_personal=" . $datos['id']));
        $personal->setDatosLaborales($this->getDatosLaborales("id_personal=" . $datos['id'])); 
        return $personal;
    }
    
    public function getDatosLaborales($where)
    {
//        $sql = "SELECT cronos_rrhh_datos_laborales.*,
//                cronos_terapias.terapia, cronos_terapias.id
//                FROM cronos_rrhh_datos_laborales, cronos_terapias
//                WHERE cronos_rrhh_datos_laborales." . $where . " AND
//                cronos_terapias.id = cronos_rrhh_datos_laborales.puesto
//                ";
        $sql = "SELECT * FROM " . PRE_TABLE . "personal_datos_laborales
                WHERE $where";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearDatosLaborales($this->_db->fetchall());
    }
    
    public function getContactosPersonal($where)
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'contacto_personal WHERE eliminado = ' .
                $this->_verEliminados . ' AND ' . $where . ' ORDER BY tipoContacto';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearContactos($this->_db->fetchall());
    }
    
    private function _crearContactos($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = new ContactoPersonal($datos);
            }
        }
        return $resultado;
    }
    
    private function _crearDatosLaborales($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = new datosLaboralesPersonal($datos);
            }
        }
        return $resultado;
    }
    
    /**
     * Obtener de la bd los domicilios del personal solicitado en el $where
     * @param String $where
     * @return Array
     */
    public function getDomicilioPersonal($where)
    {
        $this->_verEliminados = 0;
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'domicilios_personal WHERE eliminado = ' .
                $this->_verEliminados . ' AND ' . $where . ' ORDER BY tipo_domicilio';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearDomicilio($this->_db->fetchRow());
    }
    
    public function _crearDomicilio($datos)
    {
        return new DomicilioPersonal($datos);
    }
    
    public function _crearDomicilios($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = new DomicilioPersonal($datos);
            }
        }
        return $resultado;
    }

    public function getPersonalByNro_doc($id)
    {
        $id = (int) $id;
        $sql = "select * from " . PRE_TABLE . "personal where nro_doc = $id";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchRow();
    }

    public function insertarPersonal(array $valores)
    {
        return $this->_db->insert(PRE_TABLE . 'personal', $valores);
    }

    public function editarPersonal(array $valores, $condicion)
    {
        return $this->_db->editar(PRE_TABLE . 'personal', $valores, $condicion);
    }

    public function eliminarPersonal($condicion)
    {
        return $this->_db->eliminar(PRE_TABLE . 'personal', $condicion);
    }

    public function getPacientesPersonal($idProfesional)
    {
        $lista = NULL;
        $this->_verEliminados = 0;
        $sql = "select * from " . PRE_TABLE . "pacientes_terapia where idProfesional = $idProfesional";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $todos = $this->_db->fetchall();
        require_once BASE_PATH . 'Modulos' . DS . 'Pacientes' . DS . 'Modelos' . DS . 'Paciente.php';
        foreach ($todos as $pac) {
            $sql2 = "select * from cronos_pacientes where id = " . $pac['idPaciente'];
            $this->_db->setTipoDatos('Array');
            $this->_db->query($sql);
            $paciente = $this->_db->fetchrow();
            $lista[] = new Paciente($paciente);
        }
        return $lista;
    }
    
    /**
     * Verifica que exista un paciente
     * @param $where parametro de consulta
     * @return boolean
     */
    public function existePersonal($where)
    {
        $retorno = false;
        $sql = "SELECT * FROM " . PRE_TABLE ."personal WHERE $where";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        if($this->_db->fetchRow()){
            $retorno = true;
        }
        return $retorno;
    }
    
    public function insertarDomicilioPersonal(array $valores)
    {
        return $this->_db->insert(PRE_TABLE . 'domicilios_personal', $valores);
    }
    
    public function modificarDomicilioPersonal(array $valores,$condicion)
    {
        return $this->_db->editar(PRE_TABLE . 'domicilios_personal', $valores, $condicion);
    }
    
    public function getPersonalBySexo($sexo)
    {
        $this->_db->setTipoDatos('Array');
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'personal WHERE sexo="'.$sexo.'"';
        $this->_db->query($sql);
        return $this->_crearListaPersonal($this->_db->fetchall());
    }
    
    /**
     * Obtiene una lista de nacionalidades
     * @param string $where
     * @return Resource 
     */
    public function getNacionalidadesPersonal()
    {
        $sql = "SELECT DISTINCT nacionalidad FROM " . PRE_TABLE . "personal";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchAll();
    }

}
