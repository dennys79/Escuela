<?php

require_once BASE_PATH . 'LibQ' . DS . 'upload' . DS . 'class.upload.php';

/**
 * Clase Personal Foto Controlador 
 */
class Personal_Controladores_fotoControlador extends App_Controlador {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        ;
    }

    public function nuevo($id) {
        $ruta = BASE_PATH . 'Public' . DS . 'Img' . DS . 'Fotos' . DS . 'Personal' . DS . $id . DS;
        if (!is_dir($ruta)){
            $this->_crearCarpeta($ruta);
        }
        if (isset($_FILES['foto']['name'])) {
            $upload = new upload($_FILES['foto'], 'es_ES');
            $upload->allowed = array('image/*');
//            $upload->file_new_name_body = 'Id' . $id;
            $upload->file_new_name_ext = 'png';
            $upload->file_overwrite = true;
            $upload->process($ruta);

            if ($upload->processed) {
                $this->redireccionar('mod=Personal&cont=index&met=editar&id=' . $id);
            } else {
                $this->_msj_error = $upload->error;
                $this->redireccionar('mod=Personal&cont=index&met=editar&id=' . $id);
            }
        } else {
            echo 'no hay imagen';
        }
        $this->redireccionar('mod=Personal&cont=index&met=editar&id=' . $id);
    }

    public function borrar($archivo, $dir) {
        $id = parent::getGetParam('id');
        $file = $dir . DS . $archivo;
        unlink($file);
        $this->redireccionar('mod=Personal&cont=index&met=editar&id=' . $id);
    }
    
    private function _crearCarpeta($ruta)
    {
       var_dump($ruta);
       return mkdir($ruta);
    }

}
