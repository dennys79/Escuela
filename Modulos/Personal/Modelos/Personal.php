<?php
require_once BASE_PATH . 'LibQ' . DS . 'Sclases' . DS . 'Persona' . DS . 'Persona.php';
require_once BASE_PATH . 'LibQ' . DS . 'Sclases' . DS . 'Persona' . DS . 'Domicilio.php';

/**
 * Description of Personal
 *
 * @author WERD
 */
require_once 'DatosLaboralesPersonal.php';
require_once 'DatosContactoPersonal.php';
require_once 'ContactoModelo.php';
require_once 'LaboralModelo.php';
require_once 'IndexModelo.php';

class Personal_Modelos_Personal extends LibQ_Sclases_Persona_Persona
{
    protected $_id;
    protected $_nomina;
    protected $_cuil;
    protected $_eliminado;
    protected $_fecha_nac;
    protected $_datosLaborales;
    protected $_datosContacto;

    public function __construct($personal)
    {
        parent::__construct($personal);
        $this->_id = $personal['id'];
        $this->_nomina = $personal['nomina'];
        $this->_cuil = $personal['cuil'];
        $this->_eliminado = $personal['eliminado'];
    }
    
    private function _getListaPacientes()
    {
        $indexModelo = new indexModelo();
        $datos = $indexModelo->getPacientesPersonal($this->_id);
        return $datos;
    }

    /** Obtiene una colección de Datos de Contacto
     * @return DatosLaboralesPersonal 
     */
    private function _getDatosContacto()
    {
        $resultado = '';
        $datosContactoModelo = new Personal_Modelos_contactoModelo();
        $datos = $datosContactoModelo->getContactos($this->_id);
        if (is_array($datos)){
            foreach ($datos as $contacto) {
                $resultado[] = new datosContactoPersonal($contacto);
            }
        }
        return $resultado;
    }
    
    /** Obtiene una colección de Datos Laborales
     * @return DatosLaboralesPersonal 
     */
    private function _getDatosLaborales()
    {
        $datosLaboralesModelo = new Personal_Modelos_laboralModelo();
        $datos = $datosLaboralesModelo->getDatosLaborales($this->_id);
        return new DatosLaboralesPersonal($datos);
    }
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function getNomina()
    {
        return $this->_nomina;
    }
    
    public function getLocalidad()
    {
        return $this->_localidad;
    }
    
    public function getEdad()
    {
        $hoy = new LibQ_Fecha();
        $edad = intval($hoy->s_datediff('y', $this->getFecha_nac(), $hoy->getFecha()));
        return $edad;
    }
    
    public function getFoto()
    {
        return IMAGEN_PUBLICA . 'Fotos/Id'.$this->_id.'.png';
    }
    
    public static function getPersonal($lista = array())
    {
        foreach ($lista as $datos) {
            $resultado[] = new Personal_Modelos_Personal($datos);
        }
        return $resultado;
    }    
    
    public function getFirstDomicilio()
    {
        $dom = '';
        if (is_array($this->_domicilio) && count($this->_domicilio) > 0){
           $dom = $this->_domicilio[0];
        }else{
            $dom = $this->_domicilio;
        }
        return $dom;
    }
    
    public function getContactosPersonal()
    {
        return $this->_getDatosContacto();
    }
    
    public function  getListaPacientes()
    {
        return $this->_listaPacientes;
    }
    
    public function  setListaPacientes($lista)
    {
        $this->_listaPacientes = $lista;
    }
    
    public function setDatosLaborales($datos)
    {
        $this->_datosLaborales = $datos;
    }
    
    public function getDatosLaborales()
    {
        return $this->_getDatosLaborales();
    }
    
}


