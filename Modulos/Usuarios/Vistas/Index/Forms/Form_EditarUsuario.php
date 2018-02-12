<form name="form_editar" method="post" action="" class="form-horizontal" role="form">
    <input type="hidden" value="1" name="editar" id="editar">
    <input type="hidden" value="<?php echo $this->datos->getId(); ?>" name="id" id="id">
    <div class="form-group">
        <label for="usuario" class="required col-sm-2 control-label">Usuario:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="usuario" 
                   id="usuario" value="<?php echo $this->datos->getUserName(); ?>" 
                   maxlength="25">
        </div>
    </div>
    <div class="form-group">
        <label for="nombre" class="required col-sm-2 control-label">Nombre:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $this->datos->getNombre(); ?>" maxlength="25">
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="required col-sm-2 control-label">Nueva Contraseña:</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="password" id="password" value="" maxlength="25">
        </div>
    </div>
    <div class="form-group">
        <label for="role" class="required col-sm-2 control-label">Role:</label>
        <div class="col-sm-10">
            <select name="role" id="role" class="form-control">
                <?php
                foreach ($this->listaRoles as $DatoRole) {
                    $role = $DatoRole['role'];
                    $idRole = $DatoRole['id_role'];
                    if ($this->datos->getRole() == $role) {
                        $seleccionado = ' selected="selected" ';
                    } else {
                        $seleccionado = '';
                    }
                    echo "<option value=\"$idRole\" label=\"$role\" $seleccionado>$role</option>";
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="email" class="required col-sm-2 control-label">E-mail:</label>
        <div class="col-sm-10">
            <input type="email" class="form-control" name="email" id="email" value="<?php echo $this->datos->getEmail(); ?>" maxlength="25">
        </div>
    </div>
    <?php if ($_SESSION['level'] == 1) { ?>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="checkbox">
                    <label>
                        <?php if ($this->datos->getBloqueado() == 1) { ?>
                            <input id="bloqueado" type="checkbox" checked> Bloqueado
                        <?php } else { ?>
                            <input id="bloqueado" type="checkbox"> Bloqueado
                        <?php } ?>
                    </label>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                    <?php if ($this->datos->getEnviarMail() == 1) { ?>
                        <input id="enviar_mail" type="checkbox" checked> Enviar Email
                    <?php } else { ?>
                        <input id="enviar_mail" type="checkbox"> Enviar Email
                    <?php } ?>
                </label>
            </div>
        </div>
    </div>
    <?php if ($_SESSION['level'] == 1) { ?>
        <div class="form-group">
            <label for="fecha_registro" class="col-sm-2 control-label">Registro:</label>
            <div class="col-sm-10">
                <input type="datetime" class="form-control" name="fecha_registro" 
                       id="fecha_registro" 
                       value="<?php echo $this->datos->getFechaRegistro(); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="ultima_visita" class="col-sm-2 control-label">Ultimo Login:</label>
            <div class="col-sm-10">
                <input type="datetime" class="form-control" name="ultima_visita" 
                       id="ultima_visita" 
                       value="<?php echo $this->datos->getUltimaVisita(); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="ultima_ip" class="col-sm-2 control-label">Ultima IP:</label>
            <div class="col-sm-10">
                <input type="datetime" class="form-control" name="ultima_ip" 
                       id="ultima_ip" 
                       value="<?php echo $this->datos->getUltimaIp(); ?>">
            </div>
        </div>
    <?php } ?>
    <?php if (($this->datos->getId() == $_SESSION['id_usuario']) or ( $_SESSION['level'] == 1)) { ?>
        <div class="col-sm-offset-2 col-md-4 ui-corner-all">
            <input type="submit" class="btn btn-primary btn-block" name="boton_guardar" value="Guardar">
        </div>
        <div class="col-sm-offset-2 col-md-4 ui-corner-all">
            <input type="reset" class="btn btn-default btn-block" name="boton_cancelar" value="Cancelar">
        </div>
    <?php } ?>
</form>
