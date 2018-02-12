<?php

class Modelos_aclModelo extends App_Modelo
{
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Obtiene la categoria del usuario especificado en roleId desde
     * la tabla Usuarios
     * @param int $roleId
     * @return array
     */
    public function getRole($roleId)
    {
        $sql = "SELECT categoria FROM " . PRE_TABLE ."usuarios WHERE id = $roleId";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $role = $this->_db->fetchRow();
        return $role['categoria'];
    }
    
    /**
     * Otiene la lista de todas los roles
     * @return array
     */
    public function getRoles()
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "roles";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $roles = $this->_db->fetchAll();
        return $roles;
    }
    
    /**
     * Obtiene los permisos para el RoleId especificado
     * @param int $roleID
     * @return array
     */
    public function getPermisosRoleId($roleID = 0)
    {
        $data = array();
        $sql = "SELECT * FROM " . PRE_TABLE . "permisos_role WHERE role = '{$roleID}'";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $permisos = $this->_db->fetchAll();
        if (is_array($permisos)){
            for($i = 0; $i < count($permisos); $i++){
                $data[] = $permisos[$i]['permiso'];
            }
        }
        return $data;
    }
    
    /**
     * Obtiene los permisos para un role
     * @param integer $roleID
     * @return array
     */
    public function getPermisosRole($roleID = 0)
    {
        $data = array();
        $sql = 'SELECT * FROM ' . PRE_TABLE . 'permisos_role WHERE role = ' . $roleID;
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $permisos = $this->_db->fetchAll();
        for($i = 0; $i < count($permisos); $i++){
            $key = $this->getPermisoKey($permisos[$i]['permiso']);
            if($key == ''){continue;}
            if($permisos[$i]['valor'] == 1){
                $v = true; //o igual a 1
            }
            else{
                $v = false;  //o igual a 0
            }
            
            $data[$key] = array(
                'clave' => $key,
                'valor' => $v,
                'nombre' => $this->getPermisoNombre($permisos[$i]['permiso']),
                'heredado' => TRUE,
                'id' => $permisos[$i]['permiso']
            );
        }        
        $todos = $this->getPermisosAll();
        $data = array_merge($todos, $data);
        return $data;
    }
    
    /**
     * Retorna la clave de un permiso
     * @param int $permisoID
     * @return int
     */
    public function getPermisoKey($permisoID = 0)
    {   
        $sql = "SELECT * FROM " . PRE_TABLE . "permisos "
                . 'WHERE id_permiso = ' . intval($permisoID);
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $key = $this->_db->fetchRow();   
        return $key['clave'];
    }
    
    /**
     * Retorna el nombre de un permiso
     * @param int $permisoID
     * @return string
     */
    public function getPermisoNombre($permisoID)
    {   
        $sql = "SELECT " . PRE_TABLE . "permisos.permiso FROM " . PRE_TABLE . "permisos "
                . "WHERE " . PRE_TABLE . "permisos.id_permiso = $permisoID";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $key = $this->_db->fetchRow();
        return $key['permiso'];
    }
    
    public function getPermisosUsuario($id, $roleId)
    {
//        LibQ_Debug::print_debug($roleId);
        $data = array();
        $ids = $this->getPermisosRoleId($roleId);
        if (count($ids)){
            $sql = "SELECT * FROM " . PRE_TABLE . "permisos_usuario " .
                "WHERE usuario = {$id} " .
                "AND permiso in (" . implode(',',$ids) . ")";                        
            $this->_db->setTipoDatos('Array');
            $this->_db->query($sql);
            $permisos = $this->_db->fetchAll();
        }else{
            $permisos = array();
        }
        for($i = 0; $i < count($permisos); $i++){
            $key = $this->getPermisoKey($permisos[$i]['permiso']);
            if($key == ''){continue;}
            if($permisos[$i]['valor'] == 1){
                $v = true;
            }
            else{
                $v = false;
            }
            
            $data[$key] = array(
                'clave' => $key,
                'valor' => $v,
                'nombre' => $this->getPermisoNombre($permisos[$i]['permiso']),
                'heredado' => FALSE,
                'id' => $permisos[$i]['permiso']
            );
        }
        return $data;
        
    }
    
    /**
     * Obtiene una lista de todos los permisos
     * @return array
     */
    public function getPermisosAll()
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "permisos";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        $permisos = $this->_db->fetchAll();
        
        for($i = 0; $i < count($permisos); $i++){
            if($permisos[$i]['clave']==''){continue;}
            $data[$permisos[$i]['clave']] = array(
                'clave' => $permisos[$i]['clave'],
                'valor' => 'x',
                'nombre' => $permisos[$i]['permiso'],
                'id' => $permisos[$i]['id_permiso']
            );
        }
        
        return $data;
    }
    
    public function insertarRole($role)
    {
        $this->_db->query("INSERT INTO " . PRE_TABLE . "roles VALUES(null, '{$role}')");
    }
    
    public function getPermisos()
    {
        $permisos = $this->_db->query("SELECT * FROM " . PRE_TABLE . "permisos");
        
        return $permisos->fetchAll(PDO::FETCH_ASSOC);
    }
    
    /**
     * Elimina el permiso de un role
     * @param int $roleID
     * @param int $permisoID
     */
    public function eliminarPermisoRole($roleID, $permisoID)
    {
        $sql = "DELETE FROM " . PRE_TABLE . "permisos_role " . 
                "WHERE permiso = {$permisoID} " .
                "AND role = {$roleID}";
        return $this->_db->query($sql);
    }

    /**
     * Edita el permiso de un role
     * @param int $roleID
     * @param int $permisoID
     * @param int $valor
     */
    public function editarPermisoRole($roleID, $permisoID, $valor)
    {
        $sql = "replace into " . PRE_TABLE . "permisos_role set role = {$roleID}, permiso = {$permisoID}, valor = '{$valor}'";
        return $this->_db->query($sql);
    }

    /**
     * Da de alta un permiso
     * @param int $permiso
     * @param int $llave
     */
    public function insertarPermiso($permiso, $llave)
    {
        $this->_db->query(
                "INSERT INTO " . PRE_TABLE . "permisos VALUES" .
                "(null, '{$permiso}', '{$llave}')"
                );
    }
}