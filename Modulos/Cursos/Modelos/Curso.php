<?php

/**
 * Clase Curso
 * @author WERD
 */
class Curso_Modelos_Curso
{
    protected $_id;
    protected $_ciclo;
    protected $_observaciones;


    public function __construct($curso=array())
    {
        $this->_id = $curso['id'];
        $this->_curso = $curso['curso'];
        $this->_observaciones = $curso['observaciones'];
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getCurso()
    {
        return $this->_curso;
    }
    
    public function getObservaciones()
    {
        return $this->_observaciones;
    }
}