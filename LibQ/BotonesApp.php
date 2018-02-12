<?php

class LibQ_BotonesApp
{

    private $_paramBotonInicio = array(
        'href' => "?option=Index",
        'classIcono' => 'icono-inicio32',
        'titulo' => 'Inicio',
        'icono' => 'glyphicon glyphicon-home',
        'class' => 'btn btn-default'
    );
    
    /**
     * Propiedad usada para configurar el botón VOLVER
     * @var type Array
     */
    private $_paramBotonVolver = array(
        'href' => "javascript:history.back(1)",
        'classIcono' => 'icono-volver32',
        'titulo' => 'Volver',
        'icono' => 'fa fa-chevron-left',
        'class' => 'btn btn-primary'
    );
    
    public function __construct()
    {
    }

    public function getParamBotonVolver()
    {
        return $this->_paramBotonVolver;
    }
    
    public function getParamBotonInicio()
    {
        return $this->_paramBotonInicio;
    }
    

}
