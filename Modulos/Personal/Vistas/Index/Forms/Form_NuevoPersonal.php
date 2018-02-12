<form id="nuevo_personal" method="post" action="" class="form-horizontal" role="form">
    <div class="col-md-7 ui-corner-all">
        <input type="hidden" name="guardar" value="1" />
        <div class="form-group">
            <label for="apellidos" class="required col-sm-2 control-label">Apellidos:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="apellidos"
                       id="apellidos" maxlength="25">
            </div>
        </div>
        <div class="form-group">
            <label for="nombres" class="required col-sm-2 control-label">Nombres:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nombres"
                       id="nombres" maxlength="25">
            </div>
        </div>
        <div class="form-group">
            <label for="nacionalidad" class="required col-sm-2 control-label">Nacionalidad:</label>
            <div class="col-sm-10">
                <select name="nacionalidad" id="nacionalidad" class="form-control">
                    <option value="ARGENTINA" label="ARGENTINA">ARGENTINA</option>
                    <option value="PARAGUAY" label="PARAGUAY">PARAGUAY</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="tipo_doc" class="optional col-sm-2 control-label">Tipo Doc:</label>
            <div class="col-sm-10">
                <select name="tipo_doc" id="tipo_doc" class="form-control">
                    <option value="0" label="DNI" selected="selected">DNI</option>
                    <option value="1" label="CI">CI</option>
                </select>
            </div>    
        </div>
        <div class="form-group">
            <label for="nro_doc" class="required col-sm-2 control-label">DNI:</label>
            <div class="col-sm-10">
                <input type="text" class="input" name="nro_doc" id="nro_doc"
                       value="" class="form-control" required
                       data-bv-notempty-message="El Nro de Documento es obligatorio">
            </div>
        </div>
        <div class="form-group">
            <label for="cuil" class="required col-sm-2 control-label">CUIL:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="cuil"
                       id="cuil">
            </div>
        </div>                
        <div class="form-group">
            <label for="sexo" class="optional col-sm-2 control-label">Sexo:</label>
            <div class="col-sm-10">
                <select name="sexo" id="sexo" class="form-control">
                    <option value="VARON" label="VARON">VARON</option>
                    <option value="MUJER" label="MUJER">MUJER</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="fechaNac" class="required col-sm-2 control-label">Fecha Nac.:</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name="fechaNac"
                       id="fechaNac">
            </div>
        </div>
    </div>
    <input type="submit" class="btn btn-lg btn-primary btn-block" 
           name="boton_guardar" value="Guardar">
</form>
