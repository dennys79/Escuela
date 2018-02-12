<?php
require_once BASE_PATH . 'LibQ' . DS . 'BotonesApp.php';
/**
 * Description of BotonesUsuarios
 *
 * @author WERD
 */
class BotonesAdministrator extends LibQ_BotonesApp
{
        
    private $_paramBotonEditar = array(
        'href' => "javascript:void(0);",
        'id'=>'editar',
        'disabled'=>'disabled',
        'evento' => "onclick=\"javascript: editar()\"",
        'titulo' => 'Edit',
        'icono' => 'glyphicon glyphicon-edit',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonEditarModulo = array(
        'href' => "javascript:void(0);",
        'id'=>'editarModulo',
        'disabled'=>'disabled',
        'evento' => "onclick=\"javascript: editar()\"",
        'titulo' => 'Editar',
        'icono' => 'glyphicon glyphicon-edit',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonEditarPuesto = array(
        'href' => "javascript:void(0);",
        'id'=>'editarPuesto',
        'disabled'=>'disabled',
        'evento' => "onclick=\"javascript: editar()\"",
        'titulo' => 'Editar',
        'icono' => 'glyphicon glyphicon-edit',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonNuevo = array(
        'href' => '?mod=Administrator&cont=index&met=nuevoIva',
        'classIcono' => 'icono-nuevo32',
        'titulo' => 'Nuevo',
        'icono' => 'glyphicon glyphicon-plus-sign',
        'class' => 'btn btn-danger'
    );
    
    private $_paramBotonNuevoModulo = array(
        'href' => '?mod=Administrator&cont=index&met=nuevoModulo',
        'classIcono' => 'icono-nuevo32',
        'titulo' => 'Nuevo',
        'icono' => 'glyphicon glyphicon-plus-sign',
        'class' => 'btn btn-danger'
    );
    
    private $_paramBotonNuevoPuesto = array(
        'href' => '?mod=Administrator&cont=index&met=nuevoPuesto',
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
        'class' => 'btn btn-primary',
        'titulo'=>'Eliminar',
        'icono' => 'glyphicon glyphicon-trash'
    );
    
    private $_paramBotonEliminarModulo = array(
        'href' => "javascript:void(0);",
        'id'=>'eliminar',
        'disabled'=>'disabled',
        'evento' => "onclick=\"javascript: eliminar()\"",
        'class' => 'btn btn-primary',
        'titulo'=>'Eliminar',
        'icono' => 'glyphicon glyphicon-trash'
    );
    
    private $_paramBotonEliminarPuesto = array(
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
        'href' => 'index.php?mod=Administrator&cont=index&met=iva',
        'classIcono' => 'icono-lista32',
        'titulo' => 'Lista Iva',
        'icono' => 'glyphicon glyphicon-usd',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonListaModulo = array(
        'href' => 'index.php?mod=Administrator&cont=index&met=modulos',
        'classIcono' => 'icono-lista32',
        'titulo' => 'Lista Módulo',
        'icono' => 'glyphicon glyphicon-menu-hamburger',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonListaPuestos = array(
        'href' => 'index.php?mod=Administrator&cont=index&met=puestos',
        'classIcono' => 'icono-lista32',
        'titulo' => 'Lista Puestos',
        'icono' => 'glyphicon glyphicon-briefcase',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonIva = array(
        'href' => 'index.php?mod=Administrator&cont=index&met=iva',
        'classIcono' => 'icono-lista32',
        'titulo' => 'IVA',
        'icono' => 'glyphicon glyphicon-usd',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonModulos = array(
        'href' => 'index.php?mod=Administrator&cont=index&met=modulos',
        'classIcono' => 'icono-lista32',
        'titulo' => 'Módulos',
        'icono' => 'glyphicon glyphicon-menu-hamburger',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonPuestos = array(
        'href' => 'index.php?mod=Administrator&cont=index&met=puestos',
        'classIcono' => 'icono-lista32',
        'titulo' => 'Puestos',
        'icono' => 'glyphicon glyphicon-briefcase',
        'class' => 'btn btn-primary'
    );
    
    /**
     * Propiedad usada para configurar el botón Imprimir
     * @var type Array
     */
    private $_paramBotonImprimirIva = array(
        'href' => 'index.php?mod=Administrator&cont=index&met=imprimirListaIva',
        'titulo' => 'Imprimir Lista',
        'classIcono' => 'icono-imprimir',
        'icono' => 'glyphicon glyphicon-print',
        'class' => 'btn btn-primary'
    );
    
    /**
     * Propiedad usada para configurar el botón Imprimir
     * @var type Array
     */
    private $_paramBotonImprimirModulos = array(
        'href' => 'index.php?mod=Administrator&cont=index&met=imprimirListaModulos',
        'titulo' => 'Imprimir Lista',
        'classIcono' => 'icono-imprimir',
        'icono' => 'glyphicon glyphicon-print',
        'class' => 'btn btn-primary'
    );
    
    /**
     * Propiedad usada para configurar el botón Imprimir
     * @var type Array
     */
    private $_paramBotonImprimirPuestos = array(
        'href' => 'index.php?mod=Administrator&cont=index&met=imprimirListaPuestos',
        'titulo' => 'Imprimir Lista',
        'classIcono' => 'icono-imprimir',
        'icono' => 'glyphicon glyphicon-print',
        'class' => 'btn btn-primary'
    );

    public function __construct()
    {
        parent::__construct();
    }

    public function getParamBotonNuevoError()
    {
        return $this->_paramBotonNuevoPermiso;
    }
    
    public function getParamBotonNuevo()
    {
        return $this->_paramBotonNuevo;
    }
    
    public function getParamBotonNuevoModulo()
    {
        return $this->_paramBotonNuevoModulo;
    }
    
    public function getParamBotonNuevoPuesto()
    {
        return $this->_paramBotonNuevoPuesto;
    }
        
    public function getParamBotonEditar()
    {
        return $this->_paramBotonEditar;
    }
    
    public function getParamBotonEditarModulo()
    {
        return $this->_paramBotonEditarModulo;
    }
    
    public function getParamBotonEditarPuesto()
    {
        return $this->_paramBotonEditarPuesto;
    }
    
    public function getParamBotonEliminar()
    {
        return $this->_paramBotonEliminar;
    }
    
    public function getParamBotonEliminarModulo()
    {
        return $this->_paramBotonEliminarModulo;
    }
    
    public function getParamBotonEliminarPuesto()
    {
        return $this->_paramBotonEliminarPuesto;
    }
    
    public function getParamBotonGuardar()
    {
        return $this->_paramBotonGuardar;
    }
    
    public function getParamBotonLista()
    {
        return $this->_paramBotonLista;
    }
    
    public function getParamBotonListaModulo()
    {
        return $this->_paramBotonListaModulo;
    }
    
    public function getParamBotonListaPuestos()
    {
        return $this->_paramBotonListaPuestos;
    }
    
    public function getParamBotonIva()
    {
        return $this->_paramBotonIva;
    }
    
    public function getParamBotonModulos()
    {
        return $this->_paramBotonModulos;
    }
    
    public function getParamBotonPuestos()
    {
        return $this->_paramBotonPuestos;
    }
    
    public function getParamBotonImprimirIva()
    {
        return $this->_paramBotonImprimirIva;
    }
    
    public function getParamBotonImprimirModulos()
    {
        return $this->_paramBotonImprimirModulos;
    }
    
    public function getParamBotonImprimirPuestos()
    {
        return $this->_paramBotonImprimirPuestos;
    }


}
