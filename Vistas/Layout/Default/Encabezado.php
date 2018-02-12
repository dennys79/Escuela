<?php include_once APP_PATH . 'Defines.php'; ?>
<?php if (isset($this->_bodyOnLoad[0])) { ?>
    <body <?php echo 'onLoad="' . $this->_bodyOnLoad[0] . '"'; ?>>
    <?php } else { ?>
    <body>
    <?php } ?>
        <header id="page-header" class="header container-fluid">
            <div class="row">
            <?php include 'TituloSitio.php'; ?>
            <?php include 'TituloDerecha.php'; ?>            
            </div>
        </header>
    <div class="container-fluid">
        <?php
        if (isset($this->_mensaje)) {
            include 'AreaMensaje.php';
        }
        if (isset($this->_msj_error)) {
            include 'AreaError.php';
        }
        ?>

