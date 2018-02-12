<?php

/**
 * Crea un Select para usar como campo pais
 *
 * @author werd
 */
class LibQ_Html_Form_Element_Input_Autocomplete_Diagnostico {

    protected $_value;
    protected $_lista;

    public function __construct($valor='', $lista=array()) {
        $this->_value = $valor;
        $this->_lista = $lista;
    }

    public function render() {
        echo '<div class="form-group">';
        echo '<label for="diagnostico" class="required col-sm-2 control-label">Patología:</label>';
        echo '<div class="col-sm-10">';
        echo '<input type="text" name="diagnostico" id="diagnostico" value="'. $this->_value.'" class="form-control">';
        echo '</div>';
        echo '</div>';
        $this->_scriptJs();
    }
    
    private function _scriptJs()
    {
        $lista = '[';
        foreach ($this->_lista as $indice => $valor) {
            $lista .= '"'.$valor['diagnostico'].'",';
        }
        $lista .= ']';
        echo '<script>';
        echo '$( function() {';
        echo 'var availableTags = ' . $lista .';';
        echo 'function split( val ) {';
        echo 'return val.split( /,\s*/ );';
        echo '}';
        echo 'function extractLast( term ) {';
        echo 'return split( term ).pop();';
        echo '}';
        echo '$( "#diagnostico" )';
        echo '.on( "keydown", function( event ) {';
        echo 'if ( event.keyCode === $.ui.keyCode.TAB &&';
        echo '$( this ).autocomplete( "instance" ).menu.active ) {';
        echo 'event.preventDefault();';
        echo '}';
        echo '})';
        echo '.autocomplete({';
        echo 'minLength: 0,';
        echo 'source: function( request, response ) {';
          echo 'response( $.ui.autocomplete.filter(';
            echo 'availableTags, extractLast( request.term ) ) );';
            echo '},';
        echo 'focus: function() {';
          echo 'return false;';
        echo '},';
        echo 'select: function( event, ui ) {';
          echo 'var terms = split( this.value );';
          echo 'terms.pop();';
          echo 'terms.push( ui.item.value );';
          echo 'terms.push( "" );';
          echo 'this.value = terms.join( ", " );';
          echo 'return false;';
        echo '}';
      echo '});';
        echo '} );';
        echo '</script>';
    }

}
