<form id="editar_modulo" method="post" action="" class="form-horizontal" role="form">
    <div class="col-md-7 ui-corner-all">
        <input type="hidden" name="guardar" value="1" />
        <div class="form-group">
            <label for="modulo" class="required col-sm-2 control-label">Modulo:</label>
            <div class="col-sm-10">
                <input type="text" name="modulo" id="modulo"
                       value="" 
                       maxlength="35" size="35" class="form-control"
                       required
                       data-bv-notempty-message="El modulo es obligatorio">
            </div>
        </div>        
        <div class="form-group">
            <label for="tipo" class="required col-sm-2 control-label">Tipo:</label>
            <div class="col-sm-10">
                <select name="tipo" id="tipo" class="form-control" required 
                        data-bv-notempty-message="El tipo es obligatorio">
                    <option>Aplicación</option>
                    <option>Sistema</option>
                </select>
            </div>
        </div>        
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="habilitado" id="habilitado"
                               value="habilitado"> Habilitado
                    </label>
                </div>
            </div>        
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="visible" id="visible"
                               value="visible"> Visible
                    </label>
                </div>
            </div>
        </div>        
    </div>
    <div class="form-group">
        <div class="col-md-12 ui-corner-all">
            <input type="submit" class="btn btn-lg btn-primary btn-block" name="boton_guardar" value="Guardar">
        </div>
    </div>
</form>