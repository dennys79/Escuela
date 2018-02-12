<?php

/**
 * Crea un Select para usar como campo pais
 *
 * @author werd
 */
class LibQ_Html_Form_Element_Select_Pais {

    protected $_lista;
    protected $_value;

    public function __construct($valor, $lista) {
        $this->_value = $valor;
        $this->_lista = $lista;
    }

    public function render() {
        echo '<div class="form-group">';
        echo '<label for="pais" class="col-sm-2">Pais:</label>';
        echo '<div class="col-sm-10">';
        echo '<div class="input-group">';
        echo '<span class="input-group-addon"><img class="flag flag-'.$this->_value.'" /></span>';        
        echo '<select name="pais" id="pais" class="form-control">';
        foreach ($this->_lista as $pais) {
            if ($this->_value == $pais->getCode()) {
                $seleccionado = ' selected="selected" ';
            } else {
                $seleccionado = '';
            }
            echo '<option value="' . $pais->getCode() . '" label="' . $pais->getCountry() . '" ' . $seleccionado . ' data-class="flag flag-' . $pais->getCode() . '">' . $pais->getCountry() . '</option>';
        }
        echo '</select>';
//        echo '<span class="flag flag-'.$this->_value.' my-form-control-feedback" aria-hidden="true"></span>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

}
