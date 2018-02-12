<?php
/**
 * Clase ContactoAlumno
 *
 * @author WERD
 */
class DomicilioAlumno extends LibQ_Sclases_Persona_Domicilio
{
    protected $_id;
    protected $_idAlumno;
    protected $_eliminado;
    
    public function getId()
    {
        return $this->_id;
    }
    
    public function getIdAlumno()
    {
        return $this->_idAlumno;
    }
    
    public function __construct($datos)
    {
        parent::__construct($datos);
        $this->_id = $datos['id_domicilio'];
        $this->_idAlumno = $datos['id_alumno'];
        $this->_eliminado = $datos['eliminado'];
    }
    
}
