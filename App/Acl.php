<?php
require_once BASE_PATH . 'Modelos' . DS . 'AclModelo.php';

/**
 * Description of Acl
 *
 * @author WERD
 */
class App_Acl
{
    private $_bd;
    private $_id; //el id del usuario al que se le aplica la lista de acceso
    private $_role;  //el id del role
    private $_permisos;  //los permisos ya procesados
    
    public function __construct($id = false)
    {
        if($id){
            $this->_id = (int) $id;
        }else{
            if (App_Session::get('id_usuario')){
                $this->_id = (int) App_Session::get('id_usuario');
            }else{
                $this->_id = 0;
            }
        }
        $this->_bd = new Modelos_aclModelo();
        $this->_role = (int) $this->_bd->getRole($this->_id);
        $this->_permisos = $this->_bd->getPermisosRole($this->_role);
        $this->_compilarAcl();
    }
    
    public function _compilarAcl()
    {
        $this->_permisos = array_merge(
            $this->_permisos,
            $this->getPermisosUsuario($this->_id,$this->_role)
        );
    }
    
    public function getPermisosUsuario($id, $roleId)
    {
//        LibQ_Debug::print_debug($this->_bd->getPermisosUsuario($id, $roleId));
        return $this->_bd->getPermisosUsuario($id, $roleId);
    }
    
    public function getPermisos()
    {
        if(isset($this->_permisos) && count($this->_permisos)){
            return $this->_permisos;
        }
    }
    
    /**
     * Retorna el permiso para la clave ($key) dada
     * Verifica que la clave exista en el array de permisos
     * @param String $key
     * @return boolean
     */
    public function permiso($key)
    {
        if (array_key_exists($key, $this->_permisos)) {
            if($this->_permisos[$key]['valor'] == true 
                    || $this->_permisos[$key]['valor'] == 1) {
                return TRUE;
            }
            return FALSE;
        }
    }
    
    public function getPermisosRole()
    {
        return $this->_bd->getPermisosRole();
    }
    
    /**
     * Verifica que el usuario tenga permiso para la clave ($key) dada
     * Si es True retorna Null sino se redirige a una página de error
     * @param String $key
     * @param String $error
     * @return Null
     */
    public function acceso($key, $error = 'e5050')
    {
        if ($this->permiso($key)){
            return;
        }
        
        header('location:' . BASE_URL . '?mod=Error&cont=Error&met=' . $error);
    }
        
}
