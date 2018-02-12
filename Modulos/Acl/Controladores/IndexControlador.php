<?php
require_once MODS_PATH . 'Acl' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once 'BarraHerramientasAcl.php';
require_once 'BotonesAcl.php';

/**
 * Controlador de los Errores
 *
 * @author WERD
 */
class Acl_Controladores_indexControlador extends App_Controlador
{
    private $_bd;
    private $_bt;
    private $_bh;    

    public function __construct(){
        parent::__construct();
        $this->isAutenticado();
        $this->_bd = new Acl_Modelos_indexModelo();
        $this->_bt = new BotonesAcl();
        $this->_bh = new BarraHerramientasAcl();
    }
    
    public function index()
    {       
        $this->_vista->titulo = TITULO_ACL;
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasIndex();
        $this->_vista->renderizar('index');
    }
    
    public function roles()
    {
        $this->_vista->setVistaCss(array('dataTables.bootstrap.min','select.dataTables.min'));        
        $this->_vista->setVistaJs(array('dataTables.bootstrap.min','dataTables.select.min', 'lista'));
        $this->_vista->titulo = TITULO_ROLES;
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasRoles();
        $this->_vista->datos = $this->_bd->getRoles();
        $this->_vista->renderizar('roles');
    }
    
    public function permisos()
    {   
        $this->_vista->setVistaCss(array('dataTables.bootstrap.min','select.dataTables.min'));        
        $this->_vista->setVistaJs(array('dataTables.bootstrap.min','dataTables.select.min', 'lista_permisos'));
        $this->_vista->titulo = TITULO_PERMISOS;
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasPermisos();
        $this->_vista->datos = $this->_bd->getPermisos();
        $this->_vista->renderizar('permisos');
    }
    
    public function permisos_role()
    {
        $roleId = filter_input(INPUT_GET, 'idRole');
        if(!$roleId){
            $this->redireccionar('mod=Acl&cont=index&met=roles');
        }
        $role = $this->_bd->getRole($roleId);
        
        if(!$role){
            $this->redireccionar('mod=Acl&cont=index&met=roles');
        }
        $this->_vista->titulo = TITULO_PERMISOS_ROLE . ' ' . $role['role'];
        if ($this->getIntPost('guardar') == 1) {
            $this->_guardar($roleId);
            $this->redireccionar('mod=Acl&cont=index&met=permisos_role&idRole='.$roleId);
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasPermisosRoles();
        $this->_vista->roles = $role;
        $this->_vista->permisos = $this->_bd->getPermisosRole($roleId);
        $this->_vista->renderizar('permisos_role');
    }
    
    public function nuevoRole()
    {
        $this->_vista->titulo = TITULO_NUEVO_ROLE;
        if ($this->getIntPost('guardar') == 1) {
            $this->_guardarNuevoRole();
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasPermisosRoles();
        $this->_vista->renderizar('nuevo_role');
    }
    
    public function nuevoPermiso()
    {
        $this->_vista->titulo = TITULO_NUEVO_PERMISO;
        if ($this->getIntPost('guardar') == 1) {
            if ($this->_guardarNuevoPermiso()){
                $this->_vista->_msj_error = 'Datos guardados';
            }
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasPermisosRoles();
        $this->_vista->renderizar('nuevo_permiso');
    }
    
    private function _guardarNuevoPermiso()
    {
        $permiso = array(
                'permiso'=>"'".$this->getTextoPost('permiso')."'",
                'clave'=>"'".$this->getTextoPost('clave')."'",
            );
        $permiso = implode(',', $permiso);
        return $this->_bd->nuevoPermiso($permiso);
    }
    
    public function editarRole()
    {
        $this->_vista->titulo = TITULO_EDITAR_ROLE;
        $roleId = filter_input(INPUT_GET, 'idRole');
        $role = $this->_bd->getRole($roleId)['role'];
        $this->_vista->role = $role;
        if ($this->getIntPost('guardar') == 1) {
            $role = $this->getTextoPost('role');
            $this->_editarRole($roleId , $role);
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasPermisosRoles();
        $this->_vista->renderizar('editar_role');
    }
    
    public function editarPermiso()
    {
        $this->_vista->titulo = TITULO_EDITAR_ROLE;
        $permisoId = filter_input(INPUT_GET, 'idPermiso');
        $permiso = $this->_bd->getPermiso($permisoId);
        $this->_vista->permiso = $permiso;
        if ($this->getIntPost('guardar') == 1) {
            $this->_editarPermiso();
            $this->redireccionar('mod=Acl&cont=index&met=editarPermiso&idPermiso='.$permisoId);
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasPermisosRoles();
        $this->_vista->renderizar('editar_permiso');
    }
    
    private function _editarPermiso()
    {
        $permiso = array(
                'permiso'=>$this->getTextoPost('permiso'),
                'clave'=>$this->getTextoPost('clave'),
            );
        $where = 'id_permiso = ' . $this->getIntPost('id_permiso');
        return $this->_bd->editarPermiso($permiso , $where);
    }
    
    private function _editarRole($idRole, $role)
    {
        return $this->_bd->editarRole($idRole, $role);
    }
    
    private function _guardarNuevoRole()
    {
        return $this->_bd->nuevoRole($this->getTextoPost('role'));
    }
    
    private function _guardar($id)
    {
        $values = array_keys(filter_input_array(INPUT_POST));
        $replace = array();
        $eliminar = array();
        for ($i=0; $i<count($values);$i++){
            if(substr($values[$i], 0,5) == 'perm_'){
                $permiso = (strlen($values[$i]) - 6);
                LibQ_Debug::print_debug(strlen($values[$i])-6);
                if($_POST[$values[$i]] == 'x'){
                    $eliminar[] = array(
                        'role' => $id,
                        'permiso' => substr($values[$i], -$permiso)
                    );
                }else{
                    if($_POST[$values[$i]] == 1){
                        $v = 1;
                    }else{
                        $v = 0;
                    }
                    $replace[] = array(
                        'role' => $id,
                        'permiso' => substr($values[$i], -$permiso),
                        'valor' => $v
                    );
                }
            }
        }
        for($i=0;$i<count($eliminar);$i++){
            $this->_bd->eliminarPermisosRole(
                    $eliminar[$i]['role'], 
                    $eliminar[$i]['permiso']
                    );
        }
        
        for($i = 0; $i < count($replace); $i++){
            $this->_bd->editarPermisoRole(
                    $replace[$i]['role'], 
                    $replace[$i]['permiso'],
                    $replace[$i]['valor']
                    );
        }
    }
    
}
