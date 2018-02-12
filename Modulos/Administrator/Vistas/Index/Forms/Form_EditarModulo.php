<form id="editar_modulo" method="post" action="" class="form-horizontal" role="form">
    <div class="col-md-7 ui-corner-all">
        <input type="hidden" name="editar" value="1" />
        <input type="hidden" name="id" id="id"
               value="<?php echo $this->modulo->getId(); ?>" />
        <div class="form-group">
            <label for="modulo" class="required col-sm-2 control-label">Modulo:</label>
            <div class="col-sm-10">
                <input type="text" name="modulo" id="modulo"
                       value="<?php if ($this->modulo->getModulo()) echo $this->modulo->getModulo(); ?>" 
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
                            <?php
                            foreach ($this->tiposModulo as $tipo) {
                                if ($this->modulo->getTipo() == $tipo) {
                                    $seleccionado = ' selected="selected" ';
                                } else {
                                    $seleccionado = '';
                                }
                                echo "<option value=\"$tipo\" label=\"$tipo\" $seleccionado>$tipo</option>";
                            }
                            ?>
                </select>
            </div>
        </div>        
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="habilitado" id="habilitado"
                        <?php if ($this->modulo->getHabilitado() == "1") echo " checked "; ?>
                               value="habilitado">
                        Habilitado
                    </label>
                </div>
            </div>        
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="visible" id="visible"
                        <?php if ($this->modulo->getVisible() == "1") echo " checked "; ?>
                               value="visible">
                        Visible
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