<?php include_once 'Forms/Form_DatosContacto.php'; ?>

<div id="detalleDatosContactoPersonal" class="panel-body ui-corner-all">
<?php if (isset($this->datosContacto)) { ?> 
    <table id="contenedorDetalleContactoPersonal"
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
            <?php
            if (is_array($this->datosContacto)) {
                foreach ($this->datosContacto as $contacto) {
                    if ($contacto->getId()) {
                        echo '<tr id="' . $contacto->getId() . '" class="detalleDato">';
                    } else {
                        echo '<tr id="0" class="detalleDato">';
                    }
                    ?>
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
                    <?php
                    if ($contacto->getId()) {
                        echo '<a href="JavaScript:void(0);" ' .
                        'idContacto=' . $contacto->getId() . ' idPersonal="' .
                        $this->datos->getId() . '" contexto="contacto" title="Eliminar">';
                        echo '<span class="glyphicon glyphicon-remove"></span>';
                        echo '</a>';
                    }
                    ?>
                </td>
                <?php
                echo '</tr>';
            }
            }
            ?>
        </tbody>
    </table>
<?php } ?>
</div>