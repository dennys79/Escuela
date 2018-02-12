<?php

/**
 * Crea un Input para usar como campo apellidos
 *
 * @author werd
 */
class LibQ_Html_Form_Element_Input_Nro_Doc {

    protected $_value;

    public function __construct($valor='') {
        $this->_value = $valor;
    }

    public function render() {
        echo '<div class="form-group">';
        echo '<label for="nro_doc" class="required col-sm-2 control-label">Nº Doc.:</label>';
        echo '<div class="col-sm-10">';
        echo '<input type="text" name="nro_doc" id="nro_doc" value="'. $this->_value.'" class="form-control"'
                . ' required data-bv-notempty-message="El Número de Documento es obligatorio">';
        echo '</div>';
        echo '</div>';
    }
    
}
