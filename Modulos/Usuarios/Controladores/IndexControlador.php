<?php
require_once MODS_PATH . 'Usuarios' . DS . 'Modelos' . DS . 'IndexModelo.php';
require_once 'BarraHerramientasUsuarios.php';
require_once 'BotonesUsuarios.php';
require_once LIB_PATH . 'ValidarFormulario.php';
require_once LIB_PATH . 'Esc_pdf.php';


class Usuarios_Controladores_indexControlador extends App_Controlador
{
    
    private $_bd;
    private $_bt;
    private $_bh;    

    public function __construct(){
        parent::__construct();
        $this->_bd = new Usuarios_Modelos_indexModelo();
        $this->_bt = new BotonesUsuarios();
        $this->_bh = new BarraHerramientasUsuarios();
    }
    
    public function index()
    {
        $this->_vista->setVistaCss(array('dataTables.bootstrap.min','select.dataTables.min'));        
        $this->_vista->setVistaJs(array('dataTables.bootstrap.min','dataTables.select.min', 'lista_usuarios'));
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasIndex();
        $this->_vista->titulo = TITULO_USUARIOS;
        $this->_vista->datos = $this->_bd->getUsuarios();        
        $this->_vista->renderizar('index');
    }
    
    public function eliminar()
    {
        $id = filter_input(INPUT_POST, 'idUsuario');
        if ($this->_bd->eliminarUsuario("id = $id")){
            echo 'ELIMINADO';
        }
    }
    
    public function editar()
    {
        $this->_acl->acceso('editar_usuario');
        if ($this->getIntPost('editar') == 1) {
            $this->_guardar();
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasEditar();
        $id = filter_input(INPUT_GET, 'id');
        $this->_vista->datos = $this->_bd->getUsuario($id);        
        $this->_vista->listaRoles = $this->_bd->getRoles(); 
        $this->_vista->titulo = TITULO_EDITAR_USUARIOS;
        $this->_vista->renderizar('editar');
    }
    
    public function permisos()
    {
        $idUsuario = filter_input(INPUT_GET, 'id');
        if(!$idUsuario){
            $this->redireccionar('?mod=Usuarios');
        }
        if ($this->getIntPost('guardar') == 1) {
            $this->_guardarPermisos($idUsuario);
        }
        $permisosUsuario = $this->_bd->getPermisosUsuario($idUsuario);
        $permisosRole = $this->_bd->getPermisosRole($idUsuario);
        
        if(!$permisosUsuario || !$permisosRole){
            $this->redireccionar('?mod=Usuarios');
        }
        $this->_vista->permisos = array_keys($permisosUsuario);    
        $this->_vista->usuario = $permisosUsuario;    
        $this->_vista->role = $permisosRole;    
        $this->_vista->infoUsuario = $this->_bd->getUsuario($idUsuario);
        $this->_vista->titulo = TITULO_EDITAR_PERMISOS_USUARIOS;
        $this->_vista->renderizar('permisos');
    }
    
    private function _guardarPermisos($id)
    {
        $values = array_keys(filter_input_array(INPUT_POST));
        $replace = array();
        $eliminar = array();
        for ($i=0; $i<count($values);$i++){
            if(substr($values[$i], 0,5) == 'perm_'){
                if($_POST[$values[$i]] == 'x'){
                    $eliminar[] = array(
                        'usuario' => $id,
                        'permiso' => substr($values[$i], -1)
                    );
                }else{
                    if($_POST[$values[$i]] == 1){
                        $v = 1;
                    }else{
                        $v = 0;
                    }
                    $replace[] = array(
                        'usuario' => $id,
                        'permiso' => substr($values[$i], -1),
                        'valor' => $v
                    );
                }
            }
        }
        for($i=0;$i<count($eliminar);$i++){
            $this->_bd->eliminarPermiso(
                    $eliminar[$i]['usuario'], 
                    $eliminar[$i]['permiso']
                    );
        }
        
        for($i = 0; $i < count($replace); $i++){
            $this->_bd->editarPermiso(
                    $replace[$i]['usuario'], 
                    $replace[$i]['permiso'],
                    $replace[$i]['valor']
                    );
        }
    }
    
    public function nuevo()
    {
        $this->_acl->acceso('nuevo_usuario');
        if ($this->getIntPost('nuevo') == 1) {
            $this->_guardar();
        }
        $this->_vista->_barraHerramientas = $this->_bh->getBarraHerramientasNuevo();
        $this->_vista->listaRoles = $this->_bd->getRoles(); 
        $this->_vista->titulo = TITULO_NUEVO_USUARIO;
        $this->_vista->renderizar('nuevo');
    }
    
    private function _guardar()
    {
        $rtdo = '';
        $datos = $this->_limpiarDatos();
        $errores = $this->_validarPost($datos);
        $aGuardarUsuario = $this->_prepararDatosUsuario($datos);
        if ($errores->getRetEval()) {
            $this->_vista->_msj_error = $errores->getErrString();
        } else {
            if (isset($datos['editar'])) {
                $rtdo = $this->_bd->editarUsuario($aGuardarUsuario, 'id=' . $aGuardarUsuario['id']);
            } else {
                unset($aGuardarUsuario['id']);
                $rtdo = $this->_bd->insertarUsuario($aGuardarUsuario);
            }
            if ($rtdo) {
                $this->_vista->_mensaje = 'DATOS_GUARDADOS';
            } else {
                $this->_vista->_mensaje = 'DATOS_NO_GUARDADOS';
            }
        }
        return $rtdo;
    }
    
    /**
     * Limpia los datos que vienen del Post
     * @return array $datos
     */
    private function _limpiarDatos()
    {
        $datos['guardar'] = filter_input(INPUT_POST, 'guardar', FILTER_SANITIZE_NUMBER_INT);
        $datos['editar'] = filter_input(INPUT_POST, 'editar', FILTER_SANITIZE_NUMBER_INT);
        $datos['id'] = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $datos['username'] = filter_input(INPUT_POST, 'usuario', FILTER_SANITIZE_STRING);
        $datos['nombre'] = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_STRING);
        $datos['role'] = filter_input(INPUT_POST, 'role', FILTER_SANITIZE_NUMBER_INT);
        $datos['email'] = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $datos['bloqueado'] = filter_input(INPUT_POST, 'bloqueado', FILTER_SANITIZE_STRING);
        $datos['enviar_mail'] = filter_input(INPUT_POST, 'enviar_email', FILTER_SANITIZE_STRING);
        $datos['password'] = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        return $datos;
    }
    
    /**
     * Validar los datos del POST
     * @param array $datos
     * @return \ValidarFormulario
     */
    private function _validarPost($datos)
    {
        $validar = new LibQ_ValidarFormulario();
        $validar->ValidField($datos['username'], 'text', 'El usuario no es válido');
        $validar->ValidField($datos['nombre'], 'text', 'El Nombre no es válido');
        return $validar;
    }
    
    private function _prepararDatosUsuario($datos)
    {
        if (parent::getPostParam('bloqueado')=='bloqueado'){
            $bloqueado = 1;
        }else{
            $bloqueado = 0;
        }
        if (parent::getPostParam('enviar_email')=='enviar_email'){
            $enviar_email = 1;
        }else{
            $enviar_email = 0;
        }
        $datosUsuario = array(
            'id' => $datos['id'],
            'username' => $datos['username'],
            'nombre' => $datos['nombre'],
            'categoria' => $datos['role'],
            'email' => $datos['email'],
            'bloqueado' => $bloqueado,
            'enviarMail' => $enviar_email,
//            'fecha_registro' => LibQ_Fecha::fechaLocal()
        );
        if($datos['password'] != ''){
            $datosUsuario['password'] = LibQ_Hash::getHash('sha1',$datos['password'],HASH_KEY);
        }
        return $datosUsuario;
    }
    
    public function imprimirLista() {
        $pdf = new Lib_Esc_pdf();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(0, 10, 'Lista Gral. de Usuarios',0,1,'C');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(20);
        $pdf->Cell(10, 10, 'Nro',0,0);
        $pdf->Cell(100, 10, 'Nombre',0,0);
        $pdf->Cell(0, 10, 'Role',0,1);
        $pdf->SetFont('Arial', '', 12);        
        $datos = $this->_bd->getUsuarios();
        $i = 1;
        foreach ($datos as $usuario) {
            $pdf->Cell(20);
            $pdf->Cell(10, 10, $i,0,0);
            $pdf->Cell(100, 10, utf8_decode($usuario->getNombre()),0,0);
            $pdf->Cell(0, 10, $usuario->getRole(),0,1);
            $i++;
        }
        
        $pdf->Output();
    }
}
