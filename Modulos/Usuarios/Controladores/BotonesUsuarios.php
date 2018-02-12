<?php
require_once BASE_PATH . 'LibQ' . DS . 'BotonesApp.php';

/**
 * Description of BotonesUsuarios
 *
 * @author WERD
 */
class BotonesUsuarios extends LibQ_BotonesApp
{
    private $_paramBotonPermisos = array(
        'href' => "javascript:void(0);",
        'classIcono' => 'icono-nuevo32',
        'id' => 'permisos',
        'disabled'=>'disabled',
        'evento' => "onclick=\"javascript: permisos()\"",
        'titulo' => 'Permisos',
        'icono' => 'glyphicon glyphicon-lock',
        'class' => 'btn btn-primary'
    );
     
    private $_paramBotonNuevo = array(
        'href' => '?mod=Usuarios&cont=index&met=nuevo',
        'classIcono' => 'icono-nuevo32',
        'titulo' => 'Nuevo',
        'icono' => 'glyphicon glyphicon-plus-sign',
        'class' => 'btn btn-danger'
    );
    
    private $_paramBotonEditar = array(
        'href' => "javascript:void(0);",
        'id'=>'editar',
        'disabled'=>'disabled',
        'evento' => "onclick=\"javascript: editar()\"",
        'titulo' => 'Edit',
        'icono' => 'glyphicon glyphicon-edit',
        'class' => 'btn btn-primary'
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
        'class' => 'btn btn-primary',
        'titulo'=>'Eliminar',
        'icono' => 'glyphicon glyphicon-trash'
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

    /**
     * Propiedad usada para configurar el botón LISTA
     * @var type Array
     */
    private $_paramBotonLista = array(
        'href' => 'index.php?mod=Usuarios&cont=index',
        'classIcono' => 'icono-lista32',
        'titulo' => 'Lista Usuarios',
        'icono' => 'glyphicon glyphicon-list',
        'class' => 'btn btn-primary'
    );

    /**
     * Propiedad usada para configurar el botón LISTA
     * @var type Array
     */
    protected $_paramBotonDirTelefonico = array(
        'href' => 'index.php?option=Paciente&sub=index&met=dirTelefonico',
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
        'href' => 'index.php?mod=Usuarios&cont=index&met=imprimirLista',
        'titulo' => 'Imprimir Lista',
        'classIcono' => 'icono-imprimir',
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
    
    public function getParamBotonEditar()
    {
        return $this->_paramBotonEditar;
    }
    
    public function getParamBotonEliminar()
    {
        return $this->_paramBotonEliminar;
    }
        
    public function getParamBotonGuardar()
    {
        return $this->_paramBotonGuardar;
    }
    
    public function getParamBotonLista()
    {
        return $this->_paramBotonLista;
    }
    
    public function getParamBotonDirTelefonico()
    {
        return $this->_paramBotonDirTelefonico;
    }
    
    public function getParamBotonDirOSociales()
    {
        return $this->_paramBotonDirOSociales;
    }
    
    public function getParamBotonPermisos()
    {
        return $this->_paramBotonPermisos;
    }
    
    public function getParamBotonImprimir()
    {
        return $this->_paramBotonImprimir;
    }

}
