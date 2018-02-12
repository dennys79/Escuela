<?php

try {
    require_once APP_PATH . 'App.php';
    require_once APP_PATH . 'Bootstrap.php';
    require_once APP_PATH . 'Request.php';    
    require_once APP_PATH . 'Config.php';
    require_once APP_PATH . 'Modelo.php';
    require_once APP_PATH . 'Controlador.php';
    require_once APP_PATH . 'Vista.php';
    require_once APP_PATH . 'DataBase.php';
    require_once APP_PATH . 'Session.php';
    require_once LANG_PATH . 'es_Ar.php';  
    require_once APP_PATH . 'Acl.php';
    require_once APP_PATH . 'Registro.php';
    require_once LIB_PATH . 'Debug.php';
//    require_once LIB_PATH . 'Hash.php';
} catch (Exception $e) {
    echo $e->getMessage();
}