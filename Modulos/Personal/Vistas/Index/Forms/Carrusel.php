<?php
require_once LIB_PATH . 'Html' . DS . 'Carrusel' . DS . 'Carrusel.php';
$carrusel = new LibQ_Html_Carrusel_Carrusel($this->fotos, $this->directorio_fotos, $this->datos);
$carrusel->setCaptions(TRUE);
$carrusel->render();