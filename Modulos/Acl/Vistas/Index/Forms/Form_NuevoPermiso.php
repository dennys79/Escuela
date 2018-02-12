<form name="editar_permisos_role" method="post" action="" class="form-horizontal" role="form">
    <input type="hidden" name="guardar" value="1">
    <div class="form-group">
        <label for="permiso" class="required col-sm-2 control-label">Permiso:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="permiso" id="permiso" value="" maxlength="25">
        </div>
    </div>
    <div class="form-group">
        <label for="clave" class="required col-sm-2 control-label">Key:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="clave" id="clave" value="" maxlength="25">
        </div>
    </div>
    <input type="submit" value="Guardar" class="btn btn-lg btn-primary btn-block">
</form>
