<?php

/**
 * Botón Filtrar
 * @author Walter Ruiz Diaz
 * @see BotonAbstract.php
 */
require_once 'BotonAbstract.php';

/**
 * Clase para crear el boton Nuevo
 */
class LibQ_Html_Boton_BotonImagen extends LibQ_Html_Boton_BotonAbstract
{

    function __construct($parametros)
    {
        parent::__construct($parametros);
        if (!isset($parametros['titulo'])) {
            $this->setTitle('');
        }
        if (!isset($parametros['classIcono'])) {
            $this->setClassIcono('');
        }
    }

    // public function render2()
    // {
    //     $retorno = '<div class = "col-2 col-xs-2 col-md-2">';
    //     $retorno .= '<div class = "thumbnail btn-default">';
    //     $retorno .= '<a ' . $this->_evento . '" type="button"';
    //     if (isset($this->_href)){
    //         $retorno .= ' href="' . $this->_href . '"';
    //     }
    //     $retorno .= '>';
    //     $retorno .= '<img data-src = "' . $this->_icono  .'" '
    //             . 'alt = "300x200" src = "' . $this->_icono . '">';
    //     $retorno .= '<div class = "caption text-center">';
    //     $retorno .='<span>'. $this->_titulo .'</span>';
    //     $retorno .='</div>';
    //     $retorno .='</a>';
    //     $retorno .= '</div>';
    //     $retorno .= '</div>';
    //     return $retorno;
    // }
    // public function render1()
    // {
    //     $retorno = "";
    //     $retorno .= '<div class = "klanimate fadeIn col-2 btn btn-outline-secondary" delay="0.5">';
    //             $retorno .= '<a ' . $this->_evento . ' role="button"';
    //     if (isset($this->_href)){
    //         $retorno .= ' href="' . $this->_href . '"';
    //     }
    //     $retorno .= '>';
    //     $retorno .= '<figure class="figure">';
    //     $retorno .='<img src="' . $this->_icono . '" class="figure-img img-fluid rounded" alt="'. $this->_titulo .'">';
    //     $retorno .='<figcaption class="figure-caption">'. $this->_titulo .'</figcaption>';
    //     $retorno .='</figure>';
    //     $retorno .='</a>';
    //     $retorno .= '</div>';
    //     return $retorno;
    // }
    public function render()
    {
        $retorno = "";
        $retorno .= '<a ' . $this->_evento . ' role="button"';
        if (isset($this->_href)){
            $retorno .= ' href="' . $this->_href . '"';
        }
        $retorno .= '>';
        $retorno .= '<div class = "card text-center animated fadeInRight slow" style="width: 10rem; float: left;">';
        $retorno .= '<div class = "card-block btn btn-outline-secondary">';

        // $retorno .= '<figure class="figure">';
        $retorno .='<img src="' . $this->_icono . '"
                    class="figure-img img-fluid rounded" alt="'. $this->_titulo .'">';
        $retorno .='<div>'. $this->_titulo .'</div>';
        // $retorno .='</figure>';

        $retorno .= '</div>';

        $retorno .= '</div>';
        $retorno .='</a>';
        return $retorno;
    }

}
