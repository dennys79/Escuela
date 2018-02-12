<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php if (isset($this->titulo)) echo $this->titulo ?></title>
        <?php include_once 'EstilosCss.php'; ?>
        <script type="text/javascript" src="Vistas/Layout/Default/Js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="Vistas/Layout/Default/Js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="Vistas/Layout/Default/tether/js/tether.min.js"></script>
        <script type="text/javascript" src="<?php echo $_layoutParams['ruta_bootstrap']; ?>js/bootstrap.js"></script>
        <script type="text/javascript" src="Vistas/Layout/Default/Js/jquery.dataTables.js"></script>
        <?php if (isset($_layoutParams['js']) && count($_layoutParams['js'])): ?>
            <?php foreach ($_layoutParams['js'] as $archivoJs) { ?>
                <script type = "text/javascript" src = "<?php echo $archivoJs; ?>"></script>
            <?php } ?>
        <?php endif; ?>
    </head>
