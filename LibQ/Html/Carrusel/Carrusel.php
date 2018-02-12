<?php

/**
 * Genera el html de un carrusel con bootstrap
 *
 * @author werd
 */
class LibQ_Html_Carrusel_Carrusel {

    protected $_fotos;
    protected $_dir;
    protected $_datos;
    protected $_modulo;
    protected $_captions = false;

    public function __construct($fotos, $dir, $datos) {
        $this->_fotos = $fotos;
        $this->_dir = FOTOS_PUBLIC_PATH;
        $array = $this->_controlDir($dir);
        foreach ($array as $value) {
            $this->_dir .= $value . DS;
        }
        $this->_modulo = $array['0'];
        $this->_dir = FOTOS_PUBLIC_PATH . $dir;
        $this->_datos = $datos;
    }

    public function setCaptions($caption) {
        $this->_captions = $caption;
    }

    /**
     * Renderiza el carrusel
     */
    public function render() {
        if (count($this->_fotos)) {
            echo '<div id="myCarousel" class="carousel slide ui-corner-all" data-ride="carousel" style="margin-bottom: 30px;">';
            $this->_indicators();
            $this->_slides();
            $this->_controls();
            echo '</div>';
        }
    }

    /**
     * Coloca los indicadores
     */
    private function _indicators() {
        echo '<ol class="carousel-indicators">';
        for ($i = 0; $i < count($this->_fotos); $i++) {
            if ($i == 0) {
                echo '<li data-target="#myCarousel" data-slide-to="' . $i . '" class="active"></li>';
            } else {
                echo '<li data-target="#myCarousel" data-slide-to="' . $i . '""></li>';
            }
        }
        echo '</ol>';
    }

    /**
     * Muestra las fotos
     */
    private function _slides() {
        echo '<div class="carousel-inner" role="listbox">';
        $i = 0;
        foreach ($this->_fotos as $foto) {
            if ($i == 0) {
                $this->_firstSlide($foto);
            } else {
                $this->_othersSlides($foto);
            }
            $i++;
        }
        echo '</div>';
    }

    /**
     * Coloca los controles avanzar y retroceder
     */
    private function _controls() {
        echo '<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">';
        echo '<span class="glyphicon glyphicon-chevron-left"></span>';
        echo '<span class="sr-only">Previous</span>';
        echo '</a>';
        echo '<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">';
        echo '<span class="glyphicon glyphicon-chevron-right"></span>';
        echo '<span class="sr-only">Next</span>';
        echo '</a>';
    }

    /**
     * Coloca los captions en la foto
     * @param string $foto
     * @todo Que el caption discrimine textos y botones de acción
     */
    private function _PutCaptions($foto) {
        echo '<div class="carousel-caption">';
        echo '<a href="?mod=' . $this->_modulo . '&cont=foto&met=borrar&file=' . $foto .
        '&dir=' . $this->_dir . '&id=' . $this->_datos->getId() . '" class="btn btn-default"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
        echo '</div>';
    }

    /**
     * Muestra la primer foto
     * @param string $foto es el nombre del archivo
     */
    private function _firstSlide($foto) {
        echo '<div class="item active" style="height: 280px; width: 100%;">';
        echo '<img src="' . $this->_dir . DS . $foto . '"'
        . ' alt="' . $foto . '" class="img-thumbnail" style="margin: 0 auto;">';
        if ($this->_captions) {
            $this->_PutCaptions($foto);
        }
        echo '</div>';
    }

    /**
     * Muestra las otras fotos
     * @param string $foto es el nombre del archivo
     */
    private function _othersSlides($foto) {
        echo '<div class="item" style="height: 280px; width: 100%;">';
        echo '<img src="' . $this->_dir . DS . $foto
        . '" alt="' . $foto . '" class="img-thumbnail" style="margin: 0 auto;">';
        if ($this->_captions) {
            $this->_PutCaptions($foto);
        }
        echo '</div>';
    }
    
    private function _controlDir($dir)
    {
        return explode(DS, $dir);
        
    }

}
