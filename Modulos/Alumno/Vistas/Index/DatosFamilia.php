<?php include_once 'Forms/Form_DatosFamilia.php'; ?>
<?php if (isset($this->datosFamilia)): ?>  
    <div id="contenedorDetalleDatosFamilia" class="panel-body ui-corner-all">
        <table id="contenedorDetalleDatosTerapia"
               class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="tituloDetalle">Parentesco</th>
                    <th class="tituloDetalle">Nombre</th>
                    <th class="tituloDetalle">Observaciones</th>
                    <th class="tituloDetalle">Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->datosFamilia as $familia): ?>
                    <tr id="<?php if ($familia->getId()) echo $familia->getId(); ?>" class="detalleDato">
                        <td class="datoDetalle"><?php if ($familia->getParentesco()) echo $familia->getParentesco(); ?></td>
                        <td class="datoDetalle"><?php if ($familia->getNombre()) echo $familia->getNombre(); ?></td>
                        <td class="datoDetalle"><?php
                            if ($familia->getObservaciones()) {
                                echo $familia->getObservaciones();
                            } else {
                                echo '-';
                            }
                            ?></td>
                        <td class="editcontrol">
                            <a href="JavaScript:void(0);" 
                               idFamilia=<?php if ($familia->getId()) echo $familia->getId(); ?> 
                               idAlumno="<?php if ($this->datos->getId()) echo $this->datos->getId(); ?>" 
                               contexto="familia_alumno" title="Eliminar">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </td>

                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <?php
 endif ?>