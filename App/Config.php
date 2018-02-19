<?php

$url = new LibQ_Url(LibQ_Url::obtenerURL());

if($url->getHost()=='localhost'){
    define('BASE_URL', 'http://localhost/Escuela/');
    define('DB_USER','root');
    define('DB_PASS','');
    define('DB_NAME','xxxxxxxxxxx');
}  else {
    define('BASE_URL', 'http://www.sitio.com.ar/Escuela/');
    define('DB_USER','xxxxxxxxxxxx');
    define('DB_PASS','xxxxxxxxxxxx');
    define('DB_NAME','xxxxxxxxxxxxxx');
}

//define('DEFAULT_CONTROLADOR', 'index');
define('DEFAULT_LAYOUT', 'Default');
define('IMAGEN_PUBLICA', BASE_URL . 'Public/Img/');
define('ICONOS', BASE_URL . 'Vistas/Layout/Default/Img/iconos/');

define('SESSION_TIME',40);

define('HASH_KEY', '50d8bab41b8c2');

define('DB_HOST','localhost');

define('PRE_TABLE','escuela_');
define('DB_CHAR','utf8');

define('FPDF_FONTPATH', BASE_PATH . 'LibQ/Fpdf/font/');

define('LIMITE_REGISTROS', 15);

define('MOSTRAR_ICONOS',1);
define('MAX_FILE_SIZE',600000);

define('URL_LOGIN','mod=Login&cont=login');

define('DEBUG_SQL',0);

define('GOOGLEMAPSKEY', 'AIzaSyAOSmqogGYHrProSofmj7HZ7gr0H7QgFAg'); 
