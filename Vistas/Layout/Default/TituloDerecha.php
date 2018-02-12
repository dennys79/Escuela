<?php include_once APP_PATH . 'Defines.php'; ?>
<div class="col-lg-6 col-md-6">
<?php if (App_Session::get('autenticado')) { ?>
    <div class="pull-right">
    <div id="profile-icon"></div>
    <div id="logout">
        <a href="<?php echo BASE_URL; ?>?mod=Login&cont=login&met=logout" class="logout"> Salir </a>
    </div>
    </div>
<?php } else { ?>
    <div id="msg-login" class="pull-right">
        <span class="login">Ud. no se ha identificado. (<a href="<?php echo BASE_URL; ?>?mod=Login&cont=login">Ingresar </a> )</span>
    </div>
<?php } ?>
</div>
