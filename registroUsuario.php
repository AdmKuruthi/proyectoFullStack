<?php include 'inc/header.php' ; ?>

<?php include 'inc/container.php'; ?>
<form action="./services/usuarios.php" method="post" onsubmit="return validateRegisterForm()">
    <div class="mb-3">
        <label for="username" class="form-label"> Nombre de usuario</label>
        <input id="txt_username" name="username" type="text" class="form-control" required/>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label"> Correo Electronico</label>
        <input name="txt_email" id="txt_email" type="text" class="form-control" required/>
    </div>
    <div class="mb-3">
        <label for="password1" class="form-label"> Contraseña</label>
        <input id="psswrd1" name="password1" type="password" class="form-control" placeholder="Introduzca una contraseña: Minimo 6 caracteres, 1 mayuscula, 1 minuscula y 1 digito" required/>
    </div>
    <div class="mb-3">
        <label for="password2" class="form-label"> Confirmar Contraseña</label>
        <input id="psswrd2" name="password2" type="password" class="form-control" placeholder="Introduzca nuevamente la contraseña" required/>
    </div>
    <div class="mb-3">
        <input id="registroUsuario" class="btn btn-primary" type="submit" value="Enviar">
    </div>
    <div class="p-3 mb-2 bg-danger text-white d-none">
        <span id="errorMessages"></span>
    </div>
</form>
<script src="./js/utils/validations.js" ></script>
<?php include 'inc/footer.php'; ?>