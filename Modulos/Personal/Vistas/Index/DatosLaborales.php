<form id="nuevo_personal" method="post" action="?mod=Personal&cont=laboral&met=guardar" class="form-horizontal" role="form">
    <input type="hidden" id="guardarDatosLaborales" name="guardar" value="1" />
    <input type="hidden" name="id_personal" value="<?php echo $this->datos->getId(); ?>" id="id_personal">
    <input type="hidden" name="id" value="<?php echo $this->datosLaborales->getId(); ?>" id="id">
    <div class="form-group">
        <label for="valorOcupacionEmpresa" class="col-sm-2 control-label">Ocupación en la Empresa:</label> 
        <div class="col-sm-10">
            <select name="valorOcupacionEmpresa" id="valorOcupacionEmpresa" class="form-control">
<!--                <option value="0" label="ADMINISTRATIVO" selected="selected">
                    ADMINISTRATIVO</option>-->
                <?php foreach ($this->listaOcupaciones as $ocupacion){
                    if ($ocupacion->getId() == $this->datosLaborales->getPuesto()){
                        echo '<option value="' . $ocupacion->getId() . '" label="'.
                                $ocupacion->getPuesto() . '" selected="selected">'.
                                $ocupacion->getPuesto() . '</option>';
                    } else {
                        echo '<option value="' . $ocupacion->getId() . '" label="'.
                                $ocupacion->getPuesto() .'">'.
                                $ocupacion->getPuesto() . '</option>'; 
                    }
                } ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="fechaIngreso" class="col-sm-2 control-label">Fecha Ingreso:</label> 
        <div class="col-sm-10">
            <?php echo '<input type="date" name="fechaIngreso" id="fechaIngreso" value="'.
                    $this->datosLaborales->getFechaIngreso() . '" class="form-control">'; ?>
        </div>
    </div>
    <div class="form-group">
        <label for="observacionesDatosLaborales" class="col-sm-2 control-label">Observaciones:</label> 
        <div class="col-sm-10">
            <textarea name="observacionesDatosLaborales" id="observacionesDatosLaborales" rows="4" cols="80" class="form-control">
                <?php echo $this->datosLaborales->getObservaciones(); ?>
            </textarea> 
        </div>
    </div>
    <?php if ($this->datos->getId() > 1): ?>        
        <input type="submit" class="btn btn-lg btn-primary btn-block" name="boton_guardar" value="Guardar">
    <?php endif ?>
</form>

