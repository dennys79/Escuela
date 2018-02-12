<?php

/**
 * Crea un Select para usar como campo pais
 *
 * @author werd
 */
class LibQ_Html_Form_Element_Input_Autocomplete_Nacionalidad {

    protected $_value;
    protected $_lista;

    public function __construct($valor='', $lista) {
        $this->_value = $valor;
        $this->_lista = $lista;
    }

    public function render() {
        echo '<div class="form-group">';
        echo '<label for="nacionalidad" class="required col-sm-2 control-label">Nacionalidad:</label>';
        echo '<div class="col-sm-10">';
        echo '<input type="text" name="nacionalidad" id="nacionalidad" value="'. $this->_value.'" class="form-control">';
        echo '</div>';
        echo '</div>';
        $this->_scriptJs();
    }
    
    private function _scriptJs()
    {
        $lista = '[';
        foreach ($this->_lista as $indice => $valor) {
            $lista .= '"'.$valor['nacionalidad'].'",';
        }
        $lista .= ']';
        echo '<script>';
        echo '$( function() {';
        echo 'var availableTags = ' . $lista .';';
        echo '$( "#nacionalidad" ).autocomplete({';
        echo 'source: availableTags';
        echo '});';
        echo '} );';
        echo '</script>';
    }

}
