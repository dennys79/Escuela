<?php
require_once BASE_PATH . 'Modelos' . DS . 'RegistroModelo.php';
require_once LIB_PATH . 'Fechas.php';

/**
 * Description of Acl
 *
 * @author WERD
 */
class App_Registro
{
    private $_bd;
    private $_id; //el id del usuario que produce el evento
    
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
        $this->_bd = new Modelos_registroModelo();
    }
    
    public function nuevoEvento($evento)
    {
        if (App_Session::get('id_usuario')){
            $this->_id = (int) App_Session::get('id_usuario');
        }else{
            $this->_id = 0;
        }
        $datos = array(
            'id_usuario'=>  $this->_id,
            'evento' => $evento
        );
        $this->_bd->nuevoEvento($datos);
        return;
    }
    
        
}
