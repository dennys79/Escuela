<?php

/**
 * Description of BotonesAlumnos
 *
 * @author WERD
 */
class BotonesAlumnos
{
    private $_paramBotonNuevo = array(
        'href' => '?mod=Alumno&cont=index&met=nuevo',
        'classIcono' => 'icono-nuevo32',
        'titulo' => 'Nuevo',
        'icono' => 'glyphicon glyphicon-plus-sign',
        'class' => 'btn btn-danger'
    );

    /**
     * Propiedad usada para configurar el boton ELIMINAR
     * @var type Array
     */
    private $_paramBotonEliminar = array(
        'href' => "javascript:void(0);",
        'id'=>'eliminar',
        'disabled'=>'disabled',
        'evento' => "onclick=\"javascript: eliminar()\"",
        'titulo' => 'Eliminar',
        'icono' => 'glyphicon glyphicon-trash',
        'class' => 'btn btn-primary'
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

    /**
     * Propiedad usa para configurar el botón GUARDAR
     * @var type Array
     */
    private $_paramBotonGuardar = array(
        'href' => "\"javascript:void(0);\"",
        'evento' => "onclick=\"javascript: submitbutton('Guardar')\"",
        'class' => 'btn btn-primary'
    );
    private $_paramBotonInicio = array(
        'href' => "?option=Index",
        'classIcono' => 'icono-inicio32',
        'titulo' => 'Inicio',
        'icono' => 'glyphicon glyphicon-home',
        'class' => 'btn btn-default'
    );
    
    private $_paramBotonEditar = array(
        'href' => "javascript:void(0);",
        'id'=>'editar',
        'disabled'=>'disabled',
        'evento' => "onclick=\"javascript: editar()\"",
        'titulo' => 'Editar',
        'icono' => 'glyphicon glyphicon-edit',
        'class' => 'btn btn-primary'
    );

    /**
     * Propiedad usada para configurar el botón LISTA
     * @var type Array
     */
    private $_paramBotonLista = array(
        'href' => 'index.php?mod=Alumno&cont=index',
        'classIcono' => 'icono-lista32',
        'titulo' => 'Lista de Alumnos',
        'icono' => 'glyphicon glyphicon-list',
        'class' => 'btn btn-primary'
    );

    /**
     * Propiedad usada para configurar el botón LISTA
     * @var type Array
     */
    protected $_paramBotonDirTelefonico = array(
        'href' => 'index.php?option=Alumno&sub=index&met=dirTelefonico',
        'titulo' => 'Lista de Telef.',
        'classIcono' => 'icono-dirTelefonico32',
        'icono' => 'glyphicon glyphicon-phone-alt',
        'class' => 'btn btn-primary'
    );
    
    /**
     * Propiedad usada para configurar el botón LISTA por O. Social
     * @var type Array
     */
    private $_paramBotonImprimir = array(
        'href' => 'index.php?mod=Alumno&cont=index&met=imprimirLista',
        'titulo' => 'Imprimir Lista',
        'classIcono' => 'icono-imprimir',
        'icono' => 'glyphicon glyphicon-print',
        'class' => 'btn btn-primary'
    );
    
    /**
     * Propiedad usada para configurar el botón Imprimir Ficha
     * @var type Array
     */
    private $_paramBotonImprimirFicha = array(
        'href' => "javascript:void(0);",
        'id'=>'imprimir',
        'evento' => "onclick=\"javascript: imprimirFicha()\"",
        'titulo' => 'Imprimir',
        'icono' => 'glyphicon glyphicon-print',
        'class' => 'btn btn-primary'
    );
    
    public function __construct()
    {
    }

    public function getParamBotonNuevo()
    {
        return $this->_paramBotonNuevo;
    }
    
    public function getParamBotonEliminar()
    {
        return $this->_paramBotonEliminar;
    }
    
    public function getParamBotonVolver()
    {
        return $this->_paramBotonVolver;
    }
    
    public function getParamBotonGuardar()
    {
        return $this->_paramBotonGuardar;
    }
    
    public function getParamBotonInicio()
    {
        return $this->_paramBotonInicio;
    }
    
    public function getParamBotonEditar()
    {
        return $this->_paramBotonEditar;
    }

    public function getParamBotonLista()
    {
        return $this->_paramBotonLista;
    }
    
    public function getParamBotonDirTelefonico()
    {
        return $this->_paramBotonDirTelefonico;
    }
    
    public function getParamBotonImprimir()
    {
        return $this->_paramBotonImprimir;
    }
    
    public function getParamBotonImprimirFicha()
    {
        return $this->_paramBotonImprimirFicha;
    }

}
