<?php
require_once APP_PATH . 'Modelo.php';
require_once 'Usuario.php';
require_once BASE_PATH . 'LibQ' . DS . 'Hash.php';

class Usuarios_Modelos_indexModelo extends App_Modelo
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function getUsuarios()
    {
        $sql = 'SELECT usuarios.*, roles.role FROM ' . PRE_TABLE . 'usuarios as usuarios,' . PRE_TABLE .'roles as roles 
            WHERE usuarios.categoria = roles.id_role';
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearUsuarios($this->_db->fetchall());        
    }
    
    private function _crearUsuario($datos)
    {
        $usuario = new Usuarios_Modelos_Usuario($datos);
        return $usuario;
    }
    
    private function _crearUsuarios($lista)
    {
        $resultado = array();
        if (is_array($lista) and count($lista) > 0) {
            foreach ($lista as $datos) {
                $resultado[] = $this->_crearUsuario($datos);
            }
        }
        return $resultado;
    }

        public function getUsuario($usuarioID)
    {
        $id = (int) $usuarioID;
        $sql = "SELECT usuarios.*, roles.role FROM " . PRE_TABLE . "usuarios as usuarios, " . PRE_TABLE . "roles as roles WHERE
            usuarios.categoria = roles.id_role AND usuarios.id = $id";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_crearUsuario($this->_db->fetchRow());        
    }
    
    public function getPermisosUsuario($usuarioID)
    {
        require_once APP_PATH . 'Acl.php';
        $acl = new App_Acl($usuarioID);
        return $acl->getPermisos();
    }
    
    public function getPermisosRole($usuarioID)
    {
        require_once APP_PATH . 'Acl.php';
        $acl = new App_Acl($usuarioID);
        return $acl->getPermisosRole();
    }
    
    public function eliminarPermiso($usuarioID, $permisoID)
    {
        $this->_db->query(
                "delete from " . PRE_TABLE . "permisos_usuario where ".
                "usuario = $usuarioID and permiso = " . $permisoID
                );
    }
    
    public function editarPermiso($usuarioID, $permisoID, $valor)
    {
        $this->_db->query(
                "replace into " . PRE_TABLE . "permisos_usuario set ".
                "usuario = $usuarioID , permiso = $permisoID, valor ='$valor'"
                );
    }
    
    public function getRoles()
    {
        $sql = "SELECT * FROM " . PRE_TABLE . "roles";
        $this->_db->setTipoDatos('Array');
        $this->_db->query($sql);
        return $this->_db->fetchAll();
        
    }
    
    public function editarUsuario($datos, $where)
    {
        return $this->_db->editar(PRE_TABLE . 'usuarios', $datos, $where);

    }
    
    public function insertarUsuario($datos)
    {
        return $this->_db->insert(PRE_TABLE . 'usuarios', $datos);
    }
    
    public function eliminarUsuario($condicion)
    {
        return $this->_db->eliminar(PRE_TABLE . 'usuarios', $condicion);
    }
}

