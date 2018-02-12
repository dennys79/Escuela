<?php include_once 'Forms/Form_DatosContacto.php'; ?>

<?php if (isset($this->datosContacto)){ ?> 
    <div id="detalleDatosTerapia" class="panel-body ui-corner-all">
        <table id="contenedorDetalleDatosTerapia"
               class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Tipo</th>
                    <th>Contacto</th>
                    <th>Observaciones</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($this->datosContacto as $contacto): ?>
                <tr id="<?php if ($contacto->getId()) echo $contacto->getId(); ?>"
                    class="detalleDato">
                    <td class="datoDetalle5c">
                        <?php if ($contacto->getTipo()) echo $contacto->getTipo(); ?>
                    </td>
                    <td class="datoDetalle5c">
                        <?php if ($contacto->getValor()) echo $contacto->getValor(); ?>
                    </td>
                    <td class="datoDetalle5c">
                        <?php if ($contacto->getObservaciones()) echo $contacto->getObservaciones(); ?>
                    </td>
                    <td class="editcontrol">
                        <a href="JavaScript:void(0);" 
                           id_contacto=<?php if ($contacto->getId()) echo $contacto->getId(); ?>
                           idAlumno="<?php if ($this->datos->getId()) echo $this->datos->getId(); ?>" 
                           contexto="contacto_alumno" title="Eliminar">
                            <span class="glyphicon glyphicon-remove"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
<?php } ?>