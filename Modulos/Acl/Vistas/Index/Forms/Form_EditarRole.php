<form name="editar_role" method="post" action="" class="form-horizontal" role="form">
    <input type="hidden" name="guardar" value="1">
    <div class="form-group">
        <label for="role" class="required col-sm-2 control-label">Role:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="role" id="role" value="<?php echo $this->role; ?>" maxlength="25">
        </div>
    </div>
    <input type="submit" value="Guardar" class="btn btn-lg btn-primary btn-block">
</form>
