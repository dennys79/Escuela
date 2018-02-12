<?php

/**
 * Botón Nuevo
 * @author walter
 */
require_once 'BotonInterface.php';

class LibQ_Html_Boton_BotonAbstract implements LibQ_Html_Boton_BotonInterface
{

    /**
     * @var int con el id del boton
     */
    private $_id = '';
    
    /**
     *
     * @var boolean
     */
    private $_disabled;
    
    /**
     * @var string con el contenido html
     */
    private $_botonHtml = '';

    /**
     * @var string con el nombre de la clase CSS. Predeterminado "toolbar"
     */
    protected $_class = 'toolbar';
    /**
     * @var type String con el nombre de la clase css del boton dropdown.
     */
    protected $_spanClass = '';

    /**
     * @var string con el evento que se quiere usar
     */
    protected $_evento = '';

    /**
     * @var string con el hipervínculo del botón 
     */
    protected $_href = '';

    /**
     * @var int con el tamaño predeterminado de los iconos a usar 
     */
    private $_sizeIcono = 32;

    /**
     * @var string con el nombre del icono 
     */
    protected $_icono = '';

    /**
     * @var string con el nombre de la clase a usar 
     */
    protected $_classIcono = '';

    /**
     * @var string con el titulo a mostrar 
     */
    protected $_titulo = '';
    protected $_title = '';    
    protected $_datatoggle = '';

    /**
     * Crea el botón
     */
    function __construct($parametros)
    {
        if (is_array($parametros)) {
            $this->_setOptions($parametros);
        }
    }
    
    /**
     * Establece el id del botón
     * @param string $id 
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * Establece el nombre de la clase CSS en el botón
     * @param string $class 
     */
    public function setClass($class)
    {
        $this->_class = $class;
    }

    /**
     * Devuelve el nombre de la clase CSS que usa el botón
     * @return string 
     */
    public function getClass()
    {
        return $this->_class;
    }

    /**
     * Establece el evento que se usa en el botón
     * @param string $evento 
     */
    public function setEvento($evento)
    {
        $this->_evento = $evento;
    }

    /**
     * Establece el hipervinculo donde va cuando se hace clic
     * @param string $href 
     */
    public function setHref($href)
    {
        $this->_href = $href;
    }

    /**
     * Establece el tamaño del icono a usar
     * En forma predeterminada se usa el de 32x32
     * @param int $size 
     */
    public function setSizeIcono($size)
    {
        $this->_sizeIcono = $size;
    }

    /**
     * Establece el nombre del icono a usar
     * @param string $icono 
     */
    public function setIcono($icono)
    {
        $this->_icono = $icono;
    }

    /**
     * Establece el nombre de la clase CSS que usa <span> para mostrar el icono
     * @param string $classIcono 
     */
    public function setClassIcono($classIcono)
    {
        $this->_classIcono = $classIcono;
    }

    /**
     * Establece el texto a mostrar en el botón
     * @param string $titulo 
     */
    public function setTitle($titulo)
    {
        $this->_titulo = $titulo;
    }

    /**
     * Muestra el botón
     */
    public function render()
    {
        $this->_botonHtml = '<a class="' . $this->_class . '" ' . $this->_evento . '" type="button"';
        if (isset($this->_id)){
            $this->_botonHtml .= ' id="' . $this->_id . '"';
        }
        if (isset($this->_disabled)){
            $this->_botonHtml .= ' disabled ';
        }
        if (isset($this->_href)){
            $this->_botonHtml .= ' href="' . $this->_href . '"';
        }
        if (isset($this->_datatoggle) AND $this->_datatoggle != '') {
            $this->_botonHtml .= ' data-toggle='.$this->_datatoggle.' data-placement="bottom"';
        }
        if (isset($this->_title)){
            $this->_botonHtml .= ' title="' . $this->_title . '"';
        }
        $this->_botonHtml .= '>';
        if (isset($this->_icono) AND $this->_icono != '') {
            $this->_botonHtml .= '<span class="' . $this->_icono . '"></span> ';
        }
        $this->_botonHtml .= $this->_titulo;
        
//        if (isset($this->_icono) AND $this->_icono != '') {
//            $this->_botonHtml .= '<div class="img-thumbnail"><img src="' . $this->_icono . '" alt="' . $this->_titulo .
//                    '" class="' . $this->_class . '"></div>';
//        } else {
//            if (isset($this->_spanClass)){
//                $this->_botonHtml .= '<span class="' . $this->_spanClass . '"> </span>';
//            }
//        }
        $this->_botonHtml .= '</a>';
        return $this->_botonHtml;
    }

    private function _setOptions(array $options)
    {
        if (isset($options['class'])) {
            $this->_class = $options['class'];
        }
        
        if (isset($options['id'])) {
            $this->_id = $options['id'];
        }

        if (isset($options['evento'])) {
            $this->_evento = $options['evento'];
        }

        if (isset($options['href'])) {
            $this->_href = $options['href'];
        }

        if (isset($options['icono'])) {
            $this->_icono = $options['icono'];
        }
        if (isset($options['title'])) {
            $this->_title = $options['title'];
        }

        if (isset($options['titulo'])) {
            $this->_titulo = $options['titulo'];
        }

        if (isset($options['classIcono'])) {
            $this->_classIcono = $options['classIcono'];
        }

        if (isset($options['sizeIcono'])) {
            $this->_sizeIcono = $options['sizeIcono'];
        }
        
        if (isset($options['children'])) {
            $this->_spanClass = 'caret';
        }
        
        if (isset($options['disabled'])) {
            $this->_disabled = 'disabled';
        }
        
        if (isset($options['data-toggle'])) {
            $this->_datatoggle = $options['data-toggle'];
        }

        return $this;
    }

    public function __toString()
    {
        $this->render();
    }

}
