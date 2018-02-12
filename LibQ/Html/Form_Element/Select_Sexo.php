<?php

/**
 * Crea un Select para usar como campo pais
 *
 * @author werd
 */
class LibQ_Html_Form_Element_Select_Sexo {

    protected $_lista;
    protected $_value;

    public function __construct($valor, $lista) {
        $this->_value = $valor;
        $this->_lista = $lista;
    }

    public function render() {
        echo '<div class="form-group">';
        echo '<label for="sexo" class="required col-sm-2 control-label">Sexo:</label>';
        echo '<div class="col-sm-10">';
        echo '<select name="sexo" id="sexo" class="form-control">';
        foreach ($this->_lista as $sexo) {
            if ($this->_value == $sexo) {
                $seleccionado = ' selected="selected" ';
            } else {
                $seleccionado = '';
            }
            echo '<option value="' . $sexo . '" label="' . $sexo . '" ' . $seleccionado . '">' . $sexo . '</option>';
        }
        echo '</select>';
        echo '</div>';
        echo '</div>';
    }

}
