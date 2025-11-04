<?php
$errores = [];
$lista_usuarios = leer_json(RUTA_USUARIOS);
if (isset($_POST["usuario"])) {
    $usuario = htmlspecialchars($_POST["usuario"]);

    if (in_array($usuario, $lista_usuarios)) {
        $errores["error_usuario"] = "Ese nombre de usuario ya se encuentra entre nuestros datos";
    }
}

if (isset($_POST["contrasenya"])) {
    $contrasenya = htmlspecialchars($_POST["contrasenya"]);

    if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_])[a-zA-Z\d\W_]{8,12}$/', $contrasenya)) {
        $errores["error_contrasenya"] = "La contraseña debe tener entre 8 y 12 caracteres e incluir letras y números, además de al menos un carácter especial.";   
    }
}

if (isset($_POST["rol"])) {
    $rol = htmlspecialchars($_POST["rol"]);

    if (!in_array($rol, ["admin", "usuario", "invitado"])) {
        $errores["error_rol"] = "El rol debe de ser admin, usuario o invitado";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && count($errores) == 0) {
    $contrasenya = password_hash($contrasenya, PASSWORD_DEFAULT);
    $usuario = new Usuario($usuario, $contrasenya, $rol);
    escribir_json_usuarios(RUTA_USUARIOS, $usuario);
}
?>

<!DOCTYPE html>
<html lang="es">
<?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php'; ?>

<body>
    <div class="contenedor">
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php'; ?>
        <main>
            <form method="post">
                <?php if($_SERVER["REQUEST_METHOD"] == "POST" && count($errores) == 0) echo "<p class='valido'>Se ha dado de alta el usuario de forma correcta</p>"?>
                <h2>Sign In</h2>
                <label for="usuario">Usuario: </label>
                <?php if(isset($errores["error_usuario"])) echo "<p class='error'> ". $errores['error_usuario'] . "</p>"?>
                <input type="text" name="usuario" id="usuario">
                <label for="contrasenya">Contraseña: </label>
                <?php if(isset($errores["error_contrasenya"])) echo "<p class='error'> ". $errores['error_contrasenya'] . "</p>"?>
                <input type="text" name="contrasenya" id="contrasenya">
                <label for="rol">Rol: </label>
                <?php if(isset($errores["error_rol"])) echo "<p class='error'> ". $errores['error_rol'] . "</p>"?>
                <input type="text" name="rol" id="rol">
                <a href="/login">Ya tengo usuario</a>

                <input type="submit" value="Acceder">
            </form>
        </main>
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </div>
</body>

</html>