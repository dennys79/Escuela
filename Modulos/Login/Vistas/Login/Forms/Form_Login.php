
<form method="post" action class="form-signin" role="form">
    <h2>Iniciar Sesi&oacute;n</h2>
    <input type="hidden" value="1" name="enviar" />

    <label class="sr-only">Usuario: </label>
    <input type="usuario" name="usuario" class="form-control" value="<?php if (isset($this->datos)) echo $this->datos['usuario']; ?>" placeholder="Nombre de usuario" required autofocus/>

    <label class="sr-only">Password: </label>
    <input type="password" class="form-control" name="password" placeholder="Ingrese el password" required/>

    <input type="submit" value="Ingresar" class="btn btn-lg btn-primary btn-block"/>

    <div class="login-help">
        <p class="btn btn-link"><a href="?mod=Usuarios&cont=registro">Registrarme</a></p>
        <p class="btn btn-link">Perdí mi password</p>
    </div>

</form>
