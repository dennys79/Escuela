<?php
/**
 * Description of Usuario
 *
 * @author WERD
 */
class Usuarios_Modelos_Usuario
{
    protected $_id;
    protected $_username;
    protected $_nombre;
    protected $_role;
    protected $_email;
    protected $_bloqueado;
    protected $_enviarMail;
    protected $_fechaRegistro;
    protected $_ultimaVisita;
    protected $_ultimaIp;


    public function getId()
    {
        return $this->_id;
    }
    
    public function getUsername()
    {
        return $this->_username;
    }

    public function getNombre()
    {
        return $this->_nombre;
    }
    
    public function getRole()
    {
        return $this->_role;
    }
    
    public function getEmail()
    {
        return $this->_email;
    }
    
    public function getBloqueado()
    {
        return $this->_bloqueado;
    }
    
    public function getEnviarMail()
    {
        return $this->_enviarMail;
    }
    
    public function getFechaRegistro()
    {
        return $this->_fechaRegistro;
    }
    
    public function getUltimaVisita()
    {
        return $this->_ultimaVisita;
    }
    
    public function getUltimaIp()
    {
        return $this->_ultimaIp;
    }

    public function __construct(array $usuario)
    {
        $this->_id = $usuario['id'];
        $this->_nombre = $usuario['nombre'];
        $this->_username = $usuario['username'];
        $this->_role = $usuario['role'];
        $this->_email = $usuario['email'];
        $this->_bloqueado = $usuario['bloqueado'];
        $this->_enviarMail = $usuario['enviarMail'];
        $this->_fechaRegistro = $usuario['fechaRegistro'];
        $this->_ultimaVisita = $usuario['ultimaVisita'];
        $this->_ultimaIp = $usuario['ultima_ip'];
    }
    
    public static function getUsuarios(array $usuarios)
    {
        $listaUsuarios = array();
        foreach ($usuarios as $usuario) {
            $listaUsuarios[] = new Usuario($usuario);
        }
        return $listaUsuarios;
    }
}
