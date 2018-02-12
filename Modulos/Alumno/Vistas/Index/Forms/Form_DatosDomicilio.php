<form id="nuevo_alumno" method="post" action="?mod=Alumno&cont=domicilio&met=guardar" class="form-horizontal" role="form">
    <input type="hidden" name="id_domicilio" id="id_domicilio" value="<?php echo $this->domicilio->getId(); ?>" />
    <input type="hidden" name="id_alumno" 
           value="<?php if ($this->datos->getId()) echo $this->datos->getId(); ?>" 
           id="id_alumno">
    <div class="form-group">
        <label for="calle" class="col-sm-2 required">Calle:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="calle" id="calle" value="<?php if (null != $this->domicilio->getCalle()) echo $this->domicilio->getCalle(); ?>" maxlength="25" size="25">
        </div>
    </div>
    <div class="form-group">
        <label for="casa_nro" class="col-sm-2 required">Nro:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="casa_nro" id="casa_nro" value="<?php echo $this->domicilio->getCasa_nro(); ?>" maxlength="5" size="5">
        </div>
        <label for="piso" class="col-sm-2 optional">Piso:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="piso" id="piso" value="<?php echo $this->domicilio->getPiso(); ?>" maxlength="2" size="2">
        </div>
    </div>
    <div class="form-group">
        <label for="depto" class="col-sm-2 required">Depto:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="depto" id="depto" value="<?php echo $this->domicilio->getDepto(); ?>" maxlength="2" size="2">
        </div>
    </div>
    <div class="form-group">
        <label for="barrio" class="col-sm-2 optional">Barrio:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="barrio" id="barrio" value="<?php echo $this->domicilio->getBarrio(); ?>" autocomplete="on" size="25">
        </div>
    </div>
    <div class="form-group">
        <label for="cp" class="col-sm-2 optional">C.P.:</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="cp" id="cp" value="<?php echo $this->domicilio->getCp(); ?>" autocomplete="on" maxlength="8" size="8">
        </div>
    </div>
    <div class="form-group">
        <label for="localidad" class="col-sm-2 optional">Localidad:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="localidad" id="localidad" value="<?php echo $this->domicilio->getLocalidad(); ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="provincia" class="col-sm-2 optional">Provincia:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="provincia" id="provincia" value="<?php echo $this->domicilio->getProvincia(); ?>">
        </div>
    </div>
    <?php require_once BASE_PATH . 'LibQ' . DS . 'Html'. DS . 'Form_Element'. DS .'Select_Pais.php';
        $pais = new LibQ_Html_Form_Element_Select_Pais($this->domicilio->getPais(), $this->listaCountries);
        $pais->render();
        ?>
    <?php if ($this->datos->getId()): ?>        
        <input type="submit" class="btn btn-lg btn-primary btn-block" name="boton_guardar" value="Guardar">
    <?php endif ?>
</form>    
