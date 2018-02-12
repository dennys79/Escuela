<?php

require_once MODS_PATH . 'Login' . DS . 'Modelos' . DS . 'LoginModelo.php';

class Login_Controladores_loginControlador extends App_Controlador {

    private $_login;

    public function __construct() {
        parent::__construct();
        $this->_login = new Login_Modelos_loginModelo();
    }

    public function index() {
        $this->_vista->setVistaCss(array('login'));
        $this->_vista->titulo = TITULO_LOGIN;
        if ($this->getIntPost('enviar') == 1) {
            $this->_vista->datos = filter_input_array(INPUT_POST);
            $this->_controlUsuario();
            $this->_controlPassword();
            $row = $this->_login->getUsuario(
                    $this->getAlphaNum('usuario'), $this->getSql('password')
            );
            if (!$row) {
                $this->_usuarioPasswordIncorrecto();
            }
            if ($row['bloqueado'] != 0) {
                $this->_usuarioBloqueado();
            }
            $this->_crearSesion($row);
            $this->_registro->nuevoEvento('Inició Sesión');
            $this->redireccionar();
        }
        $this->_vista->renderizar('index');
    }

    private function _usuarioBloqueado() {
        $this->_vista->_msj_error = 'Este usuario no esta habilitado';
        $this->_vista->renderizar('index', 'login');
        exit;
    }

    private function _usuarioPasswordIncorrecto() {
        $this->_vista->_msj_error = 'Usuario y/o password incorrectos';
        $this->_vista->renderizar('index', 'login');
        exit;
    }

    private function _crearSesion($row) {
        App_Session::set('autenticado', true);
        App_Session::set('level', $row['categoria']);
        App_Session::set('usuario', $row['nombre']);
        App_Session::set('id_usuario', $row['id']);
        App_Session::set('tiempo', time());
    }

    private function _controlUsuario() {
        if (!$this->getAlphaNum('usuario')) {
            $this->_vista->_msj_error = 'Debe introducir su nombre de usuario';
            $this->_vista->renderizar('index', 'login');
            exit;
        }
    }

    private function _controlPassword() {
        if (!$this->getSql('password')) {
            $this->_vista->_msj_error = ' Debe introducir su password';
            $this->_vista->renderizar('index', 'login');
            exit;
        }
    }

    public function logout() {
        $this->_registro->nuevoEvento('Cerró Sesión');
        App_Session::destroy();
        $this->redireccionar();
    }

}
