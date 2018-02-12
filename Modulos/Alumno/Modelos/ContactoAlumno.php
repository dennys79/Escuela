<?php
require_once LIB_PATH . 'Sclases' . DS . 'Contacto.php';
/**
 * Clase ContactoAlumno
 *
 * @author WERD
 */
class ContactoAlumno extends LibQ_Sclases_Contacto
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
    
    public function __construct($datos=null)
    {
        if(!is_null($datos)){
            parent::__construct($datos);
            $this->_id = $datos['id'];
            $this->_idAlumno = $datos['id_alumno'];
            $this->_eliminado = $datos['eliminado'];
        }
    }
    
    public static function getContactos($lista = array())
    {
        $resultado = array();
        if (count($lista)>0){
            foreach ($lista as $datos) {
                $resultado[] = new ContactoAlumno($datos);
            }
        }
        return $resultado;
    }
}
