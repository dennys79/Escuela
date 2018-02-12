<?php
//require_once BASE_PATH . 'Modulos' . DS . 'Personal' . DS . 'Modelos' . DS .  'Personal.php';
//require_once BASE_PATH . 'Modulos' . DS . 'Terapias' . DS . 'Modelos' . DS .  'Terapia.php';
//require_once 'PersonalAlumnoModelo.php';
//require_once 'TerapiaModelo.php';

/**
 * Clase TerapiaAlumno
 *
 * @author WERD
 */
class Alumnos_Modelos_SaludAlumno
{
    protected $_id;
    protected $_diagnostico;
    protected $_medicoDiagnostico;

        /** Métodos GET */
    public function getId()
    {
        return $this->_id;
    }
    
    public function getDiagnostico()
    {
        return $this->_diagnostico;
    }
    
    public function getMedicoDiagnostico()
    {
        return $this->_medicoDiagnostico;
    }

        public function __construct($datos)
    {
        $this->_id = $datos['id'];
        $this->_diagnostico = $datos['diagnostico'];
        $this->_medicoDiagnostico = $datos['medico_diagnostico'];
    }
    
    public function __toString()
    {
        return ''.$this->_diagnostico;
    }
    
}