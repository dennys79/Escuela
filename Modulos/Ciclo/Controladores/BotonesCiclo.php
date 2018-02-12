<?php
require_once BASE_PATH . 'LibQ' . DS . 'BotonesApp.php';
/**
 * Description of BotonesCiclos
 *
 * @author WERD
 */
class BotonesCiclo extends LibQ_BotonesApp
{
    private $_paramBotonNuevo = array(
        'href' => '?mod=Ciclo&cont=index&met=nuevo',
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
     * Propiedad usa para configurar el botón GUARDAR
     * @var type Array
     */
    private $_paramBotonGuardar = array(
        'href' => "\"javascript:void(0);\"",
        'evento' => "onclick=\"javascript: submitbutton('Guardar')\"",
        'class' => 'btn btn-primary'
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
        'href' => 'index.php?mod=Ciclo&cont=index',
        'classIcono' => 'icono-lista32',
        'titulo' => 'Lista de Ciclos',
        'icono' => 'glyphicon glyphicon-list',
        'class' => 'btn btn-primary'
    );

    /**
     * Propiedad usada para configurar el botón LISTA por O. Social
     * @var type Array
     */
    private $_paramBotonImprimir = array(
        'href' => 'index.php?mod=Ciclo&cont=index&met=imprimirLista',
        'titulo' => 'Imprimir Lista',
        'classIcono' => 'icono-imprimir',
        'icono' => 'glyphicon glyphicon-print',
        'class' => 'btn btn-primary'
    );
        
    /**
     * Propiedad usada para configurar el boton ELIMINAR
     * @var type Array
     */
    private $_paramBotonSetCicloActual = array(
        'href' => "javascript:void(0);",
        'id'=>'setCiclo_Actual',
        'disabled'=>'disabled',
        'evento' => "onclick=\"javascript: setCicloActual()\"",
        'titulo' => 'Ciclo Actual',
        'icono' => 'glyphicon glyphicon-star',
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
    
    public function getParamBotonGuardar()
    {
        return $this->_paramBotonGuardar;
    }
    
    public function getParamBotonEditar()
    {
        return $this->_paramBotonEditar;
    }

    public function getParamBotonLista()
    {
        return $this->_paramBotonLista;
    }
    
    public function getParamBotonSetCicloActual()
    {
        return $this->_paramBotonSetCicloActual;
    }
    
    public function getParamBotonDirOSociales()
    {
        return $this->_paramBotonDirOSociales;
    }
    
    public function getParamBotonImprimir()
    {
        return $this->_paramBotonImprimir;
    }
}
