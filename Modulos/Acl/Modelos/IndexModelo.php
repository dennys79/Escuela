<?php
require_once APP_PATH . 'Modelo.php';
//require_once 'Usuario.php';

class Acl_Modelos_indexModelo extends App_Modelo
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getRole($roleId)
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "roles WHERE id_role = $roleId";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchRow();                
    }
    
    public function getPermiso($permisoId)
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "permisos WHERE id_permiso = $permisoId";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchRow();                
    }
    
    public function getPermisosAll()
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "permisos";
        $this->_db->query($sql);
        $permisos = $this->_db->fetchAll();
        for($i=0;$i<count($permisos);$i++){
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
    
    public function getPermisosRole($roleId)
    {
        $data = array();
        $sql = "SELECT * FROM " . PRE_TABLE . "permisos_role WHERE role = $roleId";
        $this->_db->query($sql);
        $permisos = $this->_db->fetchAll();
//        echo '<pre>';        print_r($permisos);        echo '</pre>';
        for($i=0;$i<count($permisos);$i++){
            $key = $this->getPermisoKey($permisos[$i]['permiso']);
//            echo '<pre>';        print_r($key);        echo '</pre>';
            if ($key == ''){continue;}
            if($permisos[$i]['valor'] == 1){
                $v = 1;
            }  else {
                $v = 0;
            }
            $data[$key] = array(
                'clave' => $key,
                'valor' => $v,
                'nombre' => $this->getPermisoNombre($permisos[$i]['permiso']),
                'id' => $permisos[$i]['permiso']
            );
        }
        $data = array_merge($this->getPermisosAll(),$data);
        return $data;
    }
    
    public function eliminarPermisosRole($roleId, $permisoId)
    {
        $sql = "DELETE FROM " . PRE_TABLE . "permisos_role "
                . "WHERE role = $roleId AND permiso = $permisoId";
        return $this->_db->query($sql);
    }
    
    public function editarPermisoRole($roleId, $permisoId, $valor)
    {
        $sql = "REPLACE INTO " . PRE_TABLE . "permisos_role "
                . "SET role = $roleId, permiso = $permisoId, valor = $valor";
        return $this->_db->query($sql);
    }
    
    public function editarRole($idRole, $role)
    {
        $sql = "UPDATE " . PRE_TABLE . "roles "
                . "SET role = '$role' WHERE id_role = $idRole";
        return $this->_db->query($sql);
    }
    
    public function editarPermiso(array $valores, $condicion)
    {
        return $this->_db->editar(PRE_TABLE . 'permisos', $valores, $condicion);
    }
    
    public function nuevoRole($role)
    {
        $sql = "INSERT INTO " . PRE_TABLE . "roles "
                . "(id_role, role) VALUES (NULL,'$role')";
        return $this->_db->query($sql);
    }
    
    public function nuevoPermiso($datos)
    {
        $sql = "INSERT INTO " . PRE_TABLE . "permisos "
                . "(id_permiso, permiso, clave) VALUES (NULL,$datos)";
        return $this->_db->query($sql);
    }
    
    public function getRoles()
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "roles";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchAll();        
    }
    
    public function getPermisos()
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "permisos";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchAll();
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
}

