<form id="salud_alumno" method="post" action="?mod=Alumno&cont=salud&met=guardar" class="form-horizontal" role="form">
    <input type="hidden" name="editar" value="1" />
    <input type="hidden" name="id_alumno" id="id_alumno"
           value="<?php echo $this->datos->getId(); ?>" />        
    <input type="hidden" name="id_salud" 
           value="<?php if ($this->datosSalud->getId()) echo $this->datosSalud->getId(); ?>" />
    
        <?php require_once BASE_PATH . 'LibQ' . DS . 'Html'. DS . 'Form_Element'. DS .'Input_Autocomplete_Diagnostico.php';
        $diagnostico = new LibQ_Html_Form_Element_Input_Autocomplete_Diagnostico($this->datosSalud->getDiagnostico(), $this->listaDiagnosticos);
        $diagnostico->render();
        ?>
        
    <div class="form-group">
        <label for="medico_diagnostico" class="optional col-sm-2 control-label">Médico:</label>
        <div class="col-sm-10">
            <select name="medico_diagnostico" id="medico_diagnostico" class="form-control">
                echo '<option value="0" label="---">---</option>';
                <?php
                foreach ($this->listaMedicos as $medico) {
                    if ($this->datosSalud->getMedicoDiagnostico() == $medico['id']) {
                        $seleccionado = ' selected="selected" ';
                    } else {
                        $seleccionado = '';
                    }
                    echo '<option value="'.$medico['id'].'" label="'.$medico['apellido']. '" '.$seleccionado.'>'.$medico['apellido'].'</option>';
                }
                ?>
            </select>
<!--            <input name="medico_diagnostico" id="medico_diagnostico" class="form-control"
                   value="<?php // if ($this->datosSalud->getMedicoDiagnostico()) echo $this->daosSalud->getMedicoDiagnostico(); ?>">-->
        </div>
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-lg btn-primary btn-block" name="boton_guardar" value="Guardar">
    </div>
</form>