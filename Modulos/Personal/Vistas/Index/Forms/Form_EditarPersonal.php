<div class="col-md-7 ui-corner-all">
    <form id="editar_personal" method="post" action="" class="form-horizontal" role="form">
        <input type="hidden" name="editar" value="1" />
        <input type="hidden" name="id" id="id"
               value="<?php echo $this->datos->getId(); ?>" />
        <div class="form-group">
            <label for="apellidos" class="required col-sm-2 control-label">Apellidos:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="apellidos" id="apellidos" value="<?php echo $this->datos->getApellidos(); ?>" maxlength="25">
            </div>
        </div>
        <div class="form-group">
            <label for="nombres" class="required col-sm-2 control-label">Nombres:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nombres" id="nombres" value="<?php echo $this->datos->getNombres(); ?>" placeholder="Ingrese el nombre" maxlength="25">
            </div>
        </div>
        <?php require_once BASE_PATH . 'LibQ' . DS . 'Html'. DS . 'Form_Element'. DS .'Input_Autocomplete_Nacionalidad.php';
        $nacionalidad = new LibQ_Html_Form_Element_Input_Autocomplete_Nacionalidad($this->datos->getNacionalidad(), $this->listaNacionalidades);
        $nacionalidad->render();
        ?>
        <div class="form-group">
            <label for="tipo_doc" class="required col-sm-2 control-label">Tipo Doc:</label>
            <div class="col-sm-10">
                <select name="tipo_doc" id="tipo_doc" class="form-control">
                    <?php
                    foreach ($this->listaTipoDoc as $indice => $tipoDoc) {
                        if ($this->datos->getTipo_doc() == $indice) {
                            $seleccionado = ' selected="selected" ';
                        } else {
                            $seleccionado = '';
                        }
                        echo "<option value=\"$indice\" label=\"$tipoDoc\" $seleccionado>$tipoDoc</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="nro_doc" class="required col-sm-2 control-label">DNI:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nro_doc" id="nro_doc" value="<?php echo $this->datos->getNro_doc(); ?>" placeholder="Ingrese el nro de documento">
            </div>
        </div>
        <div class="form-group">
            <label for="cuil" class="required col-sm-2 control-label">CUIL:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="cuil"
                       id="cuil" value="<?php echo $this->datos->getCuil(); ?>" placeholder="Ingrese el nro de Cuil">
            </div>
        </div>      
        <?php require_once BASE_PATH . 'LibQ' . DS . 'Html'. DS . 'Form_Element'. DS .'Select_Sexo.php';
        $sexo = new LibQ_Html_Form_Element_Select_Sexo($this->datos->getSexo(), $this->listaSexos);
        $sexo->render();
        ?>
        <div class="form-group">
            <label for="fechaNac" class="required col-sm-2 control-label">Fecha Nacimiento:</label>
            <div class="col-sm-10">
                <?php
                if ($this->datos->getFecha_nac()) {
                    echo '<input type="date" name="fechaNac" id="fechaNac" value="' .
                    $this->datos->getFecha_nac() . '"  class="form-control">';
                }
                ?>
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-12 ui-corner-all">
                <input type="submit" class="btn btn-lg btn-primary btn-block" name="boton_guardar" value="Guardar">
            </div>
        </div>
    </form>
</div>