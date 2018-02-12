<link rel="stylesheet" href="<?php echo $_layoutParams['ruta_css']; ?>basico.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_layoutParams['ruta_bootstrap']; ?>Css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $_layoutParams['ruta_css']; ?>Sunny/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="<?php  echo $_layoutParams['ruta_css']; ?>animate.css" type="text/css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php if (isset($_layoutParams['css']) && count($_layoutParams['css'])): ?>
    <?php foreach ($_layoutParams['css'] as $archivoCss) { ?>
        <link rel="stylesheet" href="<?php echo $archivoCss; ?>"/>
    <?php } ?>
<?php endif; ?>
