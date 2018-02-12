<form id="nuevo_paciente" method="post" action="?mod=Paciente&cont=obraSocial&met=guardar" class="form-horizontal" role="form">
    <input type="hidden" id="guardarOSPaciente" name="guardarOSPaciente" value="1">
    <input type="hidden" name="id" value="<?php if ($this->datosOSocial['id']) echo $this->datosOSocial['id']; ?>" id="id">
    <input type="hidden" name="idPaciente" value="<?php if ($this->datos->getId()) echo $this->datos->getId(); ?>" id="idPaciente">
    <input type="hidden" name="idOSocial" value="<?php if ($this->datosOSocial['idOSocial']) echo $this->datosOSocial['idOSocial']; ?>" id="idOSocial">
    <div class="form-group">
        <label for="idObraSocial" class="col-sm-2 control-label">Obra Social:</label> 
        <div class="col-sm-10">
            <select name="idObraSocial" id="idObraSocial" class="form-control">
                <option value="0" label="Seleccionar">Seleccionar</option>
                <?php foreach ($this->listaOSociales as $oSocial){ ?>
                    <?php if ($oSocial->getId() == $this->datosOSocial['idOSocial']){ ?>
                        <option 
                            value="<?php echo $oSocial->getId(); ?>" 
                            label="<?php echo $oSocial->getDenominacion(); ?>" 
                            selected="selected" ><?php echo $oSocial->getDenominacion(); ?>
                        </option>
                    <?php } else { ?>
                        <option
                            value="<?php echo $oSocial->getId(); ?>"
                            label="<?php echo $oSocial->getDenominacion(); ?>">
                                <?php echo $oSocial->getDenominacion(); ?>
                        </option>
                <?php } ?>
                <?php } ?>
            </select>
                <div>
        <a id="verObraSocial" class="btn btn-sm btn-default" href="index.php?mod=ObrasSociales&cont=index&met=editar&id=<?php echo $this->datosOSocial['id']; ?>">
            Ver Detalle de la Obra Social
        </a>
    </div>

        </div>
    </div>

    <div class="form-group">
        <label for="nro_afiliado" class="col-sm-2 control-label">Nro. Afiliado:</label> 
        <div class="col-sm-10">
            <?php if ($this->datosOSocial['nro_afiliado']) { ?>
                <input type="text" name="nro_afiliado" id="nro_afiliado" 
                   value="<?php echo $this->datosOSocial['nro_afiliado']; ?>"
                   class="form-control">
            <?php } else { ?>
                <input type="text" name="nro_afiliado" id="nro_afiliado" 
                   value=""
                   class="form-control">
            <?php } ?>
        </div>
    </div>
    <div class="form-group">
        <label for="observacionesOs" class="col-sm-2 control-label">Observaciones:</label> 
        <div class="col-sm-10">
            <textarea name="observacionesOs" id="observacionesOs" rows="4" 
                      placeholder="MODULO:                CODIGO:" cols="80"
                      class="form-control">
                          <?php if ($this->datosOSocial['pacos_observaciones']) echo $this->datosOSocial['pacos_observaciones']; ?>
            </textarea>
        </div>
    </div>
    <?php if ($this->datos->getId()) { ?> 
        <input type="submit" class="btn btn-lg btn-primary btn-block" name="boton_guardar" value="Guardar">
    <?php } ?>
</form>