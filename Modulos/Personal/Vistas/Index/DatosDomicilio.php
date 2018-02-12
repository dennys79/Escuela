<div class="row ui-corner-all">
<div class="col-md-7 ui-corner-all">
<?php include_once 'Forms/Form_DatosDomicilio.php'; ?>
</div>
<div class="col-md-5 ui-corner-all">
    <div id="maps">
        <?php echo $this->jsMaps; ?>
        <?php echo $this->maps->getBodyCode(); ?>
    </div>
</div>
</div>    