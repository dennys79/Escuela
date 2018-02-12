<?php
require_once BASE_PATH . 'LibQ' . DS . 'BotonesApp.php';
/**
 * Description of BotonesUsuarios
 *
 * @author WERD
 */
class BotonesAcl extends LibQ_BotonesApp
{
//    private $_paramBotonNuevo = array(
//        'href' => '?mod=Usuarios&cont=index&met=nuevo',
//        'classIcono' => 'icono-nuevo32',
//        'titulo' => 'Nuevo',
//        'icono' => 'glyphicon glyphicon-plus-sign',
//        'class' => 'btn btn-primary'
//    );
    
    private $_paramBotonNuevoRole = array(
        'href' => '?mod=Acl&cont=index&met=nuevoRole',
        'classIcono' => 'icono-nuevo32',
        'titulo' => 'Nuevo',
        'icono' => 'glyphicon glyphicon-plus-sign',
        'class' => 'btn btn-danger'
    );
    
    private $_paramBotonNuevoPermiso = array(
        'href' => '?mod=Acl&cont=index&met=nuevoPermiso',
        'classIcono' => 'icono-nuevo32',
        'titulo' => 'Nuevo',
        'icono' => 'glyphicon glyphicon-plus-sign',
        'class' => 'btn btn-danger'
    );
    
    private $_paramBotonRoles = array(
        'href' => '?mod=Acl&cont=index&met=roles',
        'classIcono' => 'icono-nuevo32',
        'titulo' => 'Roles',
        'icono' => 'glyphicon glyphicon-menu-hamburger',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonPermisos = array(
        'href' => "javascript:void(0);",
        'classIcono' => 'icono-nuevo32',
        'id' => 'permisos',
        'disabled'=>'disabled',
        'titulo' => 'Permisos',
        'icono' => 'glyphicon glyphicon-lock',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonPermisosIndex = array(
        'href' => "?mod=Acl&cont=index&met=permisos",
        'classIcono' => 'icono-nuevo32',
        'id' => 'permisos',
        'titulo' => 'Permisos',
        'icono' => 'glyphicon glyphicon-lock',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonEditarRole = array(
        'href' => "javascript:void(0);",
        'id'=>'editar',
        'disabled'=>'disabled',
        'evento' => "onclick=\"javascript: editar()\"",
        'titulo' => 'Edit',
        'icono' => 'glyphicon glyphicon-edit',
        'class' => 'btn btn-primary'
    );
    
    private $_paramBotonEditarPermiso = array(
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
        'href' => 'index.php?option=Paciente&sub=index',
        'classIcono' => 'icono-lista32',
        'titulo' => 'Lista de Pacientes',
        'icono' => 'glyphicon glyphicon-user',
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
    private $_paramBotonDirOSociales = array(
        'href' => 'index.php?option=Paciente&sub=index&met=listaOSocial',
        'titulo' => 'Lista por O.Social',
        'classIcono' => 'icono-dirOSocial32',
        'icono' => 'glyphicon glyphicon-list-alt',
        'class' => 'btn btn-primary'
    );
    
    public function __construct()
    {
    }

    public function getParamBotonNuevoRole()
    {
        return $this->_paramBotonNuevoRole;
    }
    
    public function getParamBotonNuevoPermiso()
    {
        return $this->_paramBotonNuevoPermiso;
    }
    
    public function getParamBotonRoles()
    {
        return $this->_paramBotonRoles;
    }
    
    public function getParamBotonPermisos()
    {
        return $this->_paramBotonPermisos;
    }
    
    public function getParamBotonPermisosIndex()
    {
        return $this->_paramBotonPermisosIndex;
    }
    
    public function getParamBotonEditarRole()
    {
        return $this->_paramBotonEditarRole;
    }
    
    public function getParamBotonEditarPermiso()
    {
        return $this->_paramBotonEditarPermiso;
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

}
