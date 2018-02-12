<?php
require_once BASE_PATH . 'LibQ' . DS . 'Sclases' . DS . 'Persona' . DS . 'Persona.php';
//require_once 'TerapiaModelo.php';
//require_once 'TerapiaAlumno.php';
//require_once 'FamiliaAlumno.php';
//require_once 'FamiliaModelo.php';
//require_once 'OsocialModelo.php';
//require_once 'ObraSocialAlumno.php';
//require_once 'PlanTratamientoModelo.php';
//require_once 'PlanTratamiento.php';
//require_once 'HTerapeuticaModelo.php';
//require_once 'HTerapeutica.php';
//require_once 'EducacionAlumnoModelo.php';
//require_once 'EducacionAlumno.php';
require_once BASE_PATH . 'LibQ' . DS . 'Sclases' . DS . 'Persona' . DS . 'Domicilio.php';

/**
 * Clase Alumno extiende de la clase Libreria_SClass_Persona
 * @see Persona
 * @author WERD
 */
class Alumno_Modelos_Alumno extends LibQ_Sclases_Persona_Persona
{
    protected $_id;
    protected $_estado;
    protected $_objTerapias;
    protected $_objEducacion;
    protected $_objOSocialAlumno;
    protected $_objSalud;


    public function __construct($alumno=array())
    {
        parent::__construct($alumno);
        $this->_id = $alumno['id'];
        $this->_estado = $alumno['estado'];
    }
    
    public function setObjTerapias($datos)
    {
        $this->_objTerapias = $datos;
    }
    
    public function getObjTerapias()
    {
        return $this->_objTerapias;
    }
    
    public function getObjSalud()
    {
        return $this->_objSalud;
    }
    
    public function setObjSalud($datos)
    {
        $this->_objSalud = $datos;
    }


//    public function getDomicilio()
//    {
//        return $this->_domicilio;
//    }
    

    /**
     * 
     * @return 
     */
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

    public function getId()
    {
        return $this->_id;
    }

//    public function getDiagnostico()
//    {
//        return $this->_diagnostico;
//    }

    public function getLocalidad()
    {
        return $this->_domicilio->getLocalidad();
    }
    
    public function getEstado()
    {
        return $this->_estado;
    }
    
//    public function getNro_afiliado()
//    {
//        return $this->_nro_afiliado;
//    }
    
//    public function getPacos_observaciones()
//    {
//        return $this->_pacos_observaciones;
//    }

    public function getEdad()
    {
        $hoy = new LibQ_Fecha('now');
        $edad = intval($hoy->s_datediff('y', $this->getFecha_nac(), $hoy->getFecha()));
        return $edad;
    }

    public function getFoto()
    {
        $foto = BASE_PATH . 'Public/Img/Fotos/Alumnos/Id' . $this->_id . '.png';
        if (is_readable($foto)) {
            $retorno = IMAGEN_PUBLICA . 'Fotos/Alumnos/Id' . $this->_id . '.png';
        }else{
            $retorno = IMAGEN_PUBLICA . 'Fotos/Alumnos/idsin_imagen.png';
        }
        return $retorno;
    }

    public function getFamilia()
    {
        return $this->_familia;
    }
    
    public function setObjOSocialAlumno($oSocial)
    {
        $this->_objOSocialAlumno = $oSocial;
    }

    public function getOSocial()
    {
        return $this->_objOSocialAlumno;
    }

    public function getPlanTratamiento()
    {
        require_once 'PlanTratamientoModelo.php';
        require_once 'PlanTratamiento.php';
        $planModelo = new planTratamientoModelo();
        $datos = $planModelo->getPlanTratamientoAnio($this->_id, date("Y"));
        return new PlanTratamiento($datos);
    }
    
    /** Obtiene una colección de historias terapeuticas
     * @return HTerapeutica 
     */
    private function _getHTerapeutica()
    {
        $retorno = array();
        $hTerapeuticaModelo = new Alumno_Modelos_hTerapeuticaModelo();
        $datos = $hTerapeuticaModelo->getHTerapeutica(intval($this->_id));
        if($datos != false){
            $retorno = HTerapeutica::getHTerapeuticas($datos);
        }
        return $retorno;                        
    }
    
    public function getHTerapeutica()
    {
        $resultado = '';
        if (count($this->_objHTerapeutica)>0){
            foreach ($this->_objHTerapeutica as $hterapeutica) {
                $resultado[] = 'El <b>' . $hterapeutica->getFechaObservacion()
                        . '</b> - <b>' . $hterapeutica->getIdProfesional() . '</b> escribió:' . '<br>' .
                        $hterapeutica->getObservacion() . '<br>';
            }
        }
        if (is_array($resultado)){
            $resultado = implode('<br>', $resultado);
        }
        return $resultado;
    }
    
    public function getHTerapeuticas()
    {
        return $this->_getHTerapeutica();
    }
    
        /**
     * Estabece los datos de educacion de la persona
     * @param Array $educacion
     */
    public function setObjEducacion($educacion)
    {
        $this->_objEducacion = $educacion;
    }
    
    public function getObjEducacion()
    {
        return $this->_objEducacion;
    }
    
    /**
     * Estabece el array de contactos de la persona
     * @param Array $familia
     */
    public function setObjFamilia(Array $familia)
    {
        $this->_familia = $familia;
    }

}