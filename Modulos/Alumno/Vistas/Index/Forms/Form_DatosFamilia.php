<form id="nuevo_alumno" method="post" action="?mod=Alumno&cont=familia&met=guardar" class="form-horizontal" role="form">
    <input type="hidden" id="guardar_familia" name="guardar_familia" value="1">
    <input type="hidden" name="id_familia" value="" id="id_familia">
    <input type="hidden" name="id_alumno" value="<?php if ($this->datos->getId()) echo $this->datos->getId(); ?>" id="id_alumno">
    <div class="form-group">
        <label for="parentesco" class="col-sm-2 control-label">Parentesco:</label> 
        <div class="col-sm-10">
            <select name="parentesco" id="parentesco" class="form-control">
                <option value="Padre" label="Padre">Padre</option>
                <option value="Madre" label="Madre">Madre</option>
                <option value="Tutor" label="Tutor">Tutor</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="nombreFamilia" class="col-sm-2 control-label">Nombre:</label> 
        <div class="col-sm-10">
            <input type="text" class="form-control" name="nombreFamilia" id="nombreFamilia" value="">
        </div>
    </div>
    <div class="form-group">
        <label for="observacionesFamilia" class="col-sm-2 control-label">Observaciones:</label> 
        <div class="col-sm-10">
            <input type="text" class="form-control" name="observacionesFamilia" id="observacionesFamilia" value="">
        </div>
    </div>
    <?php if ($this->datos->getId()): ?> 
        <input type="submit" class="btn btn-lg btn-primary btn-block" name="boton_guardar" value="Guardar">
    <?php endif ?>
</form>
