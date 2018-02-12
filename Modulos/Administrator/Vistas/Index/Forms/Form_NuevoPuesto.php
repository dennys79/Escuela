<form id="nuevo_puesto" method="post" action="" class="form-horizontal" role="form">
    <div class="col-md-7 ui-corner-all">
        <input type="hidden" name="guardar" value="1" />
        <div class="form-group">
            <label for="puesto" class="required col-sm-2 control-label">Puesto:</label>
            <div class="col-sm-10">
                <input type="text" name="puesto" id="puesto"
                       value="" 
                       maxlength="35" size="35" class="form-control"
                       required
                       data-bv-notempty-message="El puesto es obligatorio">
            </div>
        </div>        
    </div>
    <div class="form-group">
        <div class="col-md-12 ui-corner-all">
            <input type="submit" class="btn btn-lg btn-primary btn-block" name="boton_guardar" value="Guardar">
        </div>
    </div>
</form>