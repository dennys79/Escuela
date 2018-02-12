<form id="nuevo_alumno" method="post" action="?mod=Alumno&cont=contacto&met=guardar" class="form-horizontal" role="form">
    <input type="hidden" id="guardar_contacto" name="guardar_contacto" value="1" />
    <input type="hidden" name="id_contacto" id="id_contacto" 
           value="" />
    <input type="hidden" name="id_alumno" 
           value="<?php if ($this->datos->getId()) echo $this->datos->getId(); ?>" 
           id="id_alumno">
    <div class="form-group">
        <label for="tipoContacto" class="optional col-sm-2 control-label">
            Tipo de Contacto:
        </label> 
        <div class="col-sm-10">
            <select name="tipoContacto" id="tipoContacto" class="form-control">
                <option value="Cel" label="Cel">Cel.</option>
                <option value="Tel" label="Tel">Tel.</option>
                <option value="Email" label="Email">Email</option>
                <option value="SitioWeb" label="SitioWeb">Sitio Web</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="valorContacto" class="optional col-sm-2 control-label">
            Contacto:
        </label> 
        <div class="col-sm-10">
            <input type="text" class="form-control" 
                   name="valorContacto" id="valorContacto" 
                   value="" placeholder="Ingrese contacto" maxlength="50">
        </div>
    </div>
    <div class="form-group">
        <label for="observacionesContactoAlumno" class="optional col-sm-2 control-label">
            Observaciones:
        </label> 
        <div class="col-sm-10">
            <input type="text" class="form-control" name="observacionesContacto" id="observacionesContacto" value="">
        </div>
    </div>
    <?php if ($this->datos->getId()): ?>        
        <input type="submit" class="btn btn-lg btn-primary btn-block" name="boton_guardar" value="Guardar">
    <?php endif ?>
</form>
