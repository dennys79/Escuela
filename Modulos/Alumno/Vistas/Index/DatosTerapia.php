<form id="nuevo_terapia_paciente" method="post" action="?mod=Paciente&cont=terapia&met=guardar" class="form-horizontal" role="form">
    <input type="hidden" id="guardar_terapia" name="guardar_terapia" value="1">
    <input type="hidden" name="id_terapia" id="id_terapia" value="" />
    <input type="hidden" name="id_paciente" value="<?php if ($this->datos->getId()) echo $this->datos->getId(); ?>" id="id_paciente">
    <div class="form-group">
        <label for="lista_terapia" class="col-sm-2 control-label">Terapia:</label> 
        <div class="col-sm-10">
            <select name="lista_terapia" id="lista_terapia" class="form-control">
                <option value="Seleccione" label="Seleccione">
                        Seleccione
                    </option>
                <?php foreach ($this->listaTerapias as $terapia): ?>
                    <option value=<?php echo $terapia->getId(); ?> label="<?php echo $terapia->getTerapia(); ?>">
                        <?php echo $terapia->getTerapia(); ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="profesional" class="col-sm-2 control-label">Profesional:</label> 
        <div class="col-sm-10">
            <select name="profesional" id="profesional" class="form-control">
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="cantidad" class="col-sm-2 control-label">Sesiones:</label> 
        <div class="col-sm-10">
            <input type="text" class="form-control" name="cantidad" id="cantidad" 
                   value="<?php if (isset($this->datosTerapia['cantidad'])) echo $this->datosTerapia['cantidad']; ?>"
                   required data-bv-notempty-message="Debe ingresar la cantidad de sesiones"
                   data-bv-field="cantidad">
        </div>
    </div>
    <div class="form-group">
        <label for="observacionesTerapia" class="col-sm-2 control-label">Observaciones:</label> 
        <div class="col-sm-10">
            <input type="text" class="form-control" name="observacionesTerapia" id="observacionesTerapia" value="<?php if (isset($this->datosTerapia['observaciones'])) echo $this->datosTerapia['observaciones']; ?>">
        </div>
    </div>
    <?php if ($this->datos->getId()): ?> 
        <input type="submit" class="btn btn-lg btn-primary btn-block" name="boton_guardar" value="Guardar">
            <?php endif ?>
            <?php if ($this->datosTerapia): ?>  
        <div id="detalleDatosTerapia" class="panel-body ui-corner-all">
            <table id="contenedorDetalleDatosTerapia"
                   class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Terapia</th>
                        <th>Profesional</th>
                        <th>Sesiones</th>
                        <th>Observaciones</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->datosTerapia as $terapia){ ?>
                        <tr <?php if ($terapia->getId()) echo "id=".$terapia->getId(); ?>
                            class="detalleDato">
                            <td><?php // print_r($terapia->getProfesional());
                            if ($terapia->getTerapia()){
                                echo $terapia->getTerapia(); 
                            }?></td>
                            <td>
                                <?php
                                if (!is_null($terapia->getProfesional()->getId())) {
                                    echo $terapia->getProfesional();
                                } else {
                                    echo '-';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($terapia->getSesiones()) echo $terapia->getSesiones(); ?>
                            </td>
                            <td>
                                <?php
                                if ($terapia->getObservaciones() && $terapia->getObservaciones() != '') {
                                    echo $terapia->getObservaciones();
                                } else {
                                    echo $terapia->getObservaciones();
                                }
                                ?>
                            </td>
                            <td>
                                <a href="JavaScript:void(0);" 
                                   idTerapia=<?php if ($terapia->getId()) echo $terapia->getId(); ?> 
                                   idPaciente="<?php if ($this->datos->getId()) echo $this->datos->getId(); ?>" 
                                   contexto="terapia_paciente" title="Eliminar">
                                    <span class="glyphicon glyphicon-remove"></span>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php endif ?>
</form>