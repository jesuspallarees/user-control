<?php
$errores = [];
if (isset($_POST["usuario"])) {
    $usuario = htmlspecialchars($_POST["usuario"]);

    if (array_key_exists($usuario, $lista_usuarios)) {
        $errores[] = "Ese nombre de usuario ya se encuentra entre nuestros datos";
    }
}

if (isset($_POST["contrasenya"])) {
    $contrasenya = htmlspecialchars($_POST["contrasenya"]);

    if (preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_])[a-zA-Z\d\W_]{8,12}$/', $contrasenya)) {
        $errores[] = "La contraseña debe tener entre 8 y 12 caracteres e incluir letras y números, además de al menos un carácter especial.";   
    }
}

if (isset($_POST["rol"])) {
    $rol = htmlspecialchars($_POST["rol"]);

    if (!array_key_exists($rol, ["admin", "usuario", "invitado"])) {
        $errores[] = "El rol debe de ser admin, usuario o invitado";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && count($errores) == 0) {
    $usuario = new Usuario($usuario, $contrasenya, $rol);
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
                <h2>Sign In</h2>
                <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario">
                <label for="contrasenya">Contraseña: </label>
                <input type="text" name="contrasenya" id="contrasenya">
                <label for="rol">Rol: </label>
                <input type="text" name="rol" id="rol">
                <a href="/login">Ya tengo usuario</a>

                <input type="submit" value="Acceder">
            </form>
        </main>
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </div>
</body>

</html>