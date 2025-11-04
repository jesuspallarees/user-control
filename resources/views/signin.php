<?php
$errores = [];
$lista_usuarios = leer_json(RUTA_USUARIOS);
if (isset($_POST["usuario"])) {
    $usuario = htmlspecialchars($_POST["usuario"]);

    $usuario_encontrado = null;
    foreach ($lista_usuarios as $usuario_lista) {
        if ($usuario_lista['usuario'] === $usuario) {
            $usuario_encontrado = $usuario_lista;
            break;
        }
    }

    if($usuario_encontrado !== null){
        $errores["error_usuario"] = "El nombre introducido ya se encuentra en nuestra base de datos";
    }
}

if (isset($_POST["contrasenya"])) {
    $contrasenya = htmlspecialchars($_POST["contrasenya"]);

    if (!preg_match('/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[\W_])[a-zA-Z\d\W_]{8,12}$/', $contrasenya)) {
        $errores["error_contrasenya"] = "La contraseña debe tener entre 8 y 12 caracteres e incluir letras y números, además de al menos un carácter especial";
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
    header("Location:/login");
    exit();
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
                <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && count($errores) == 0) echo "<p class='valido'>Se ha dado de alta el usuario de forma correcta</p>" ?>
                <h2>Sign In</h2>
                <label for="usuario">Usuario/a: </label>
                <?php if (isset($errores["error_usuario"])) echo "<p class='error'> " . $errores['error_usuario'] . "</p>" ?>
                <input type="text" name="usuario" id="usuario">
                <label for="contrasenya">Contraseña: </label>
                <?php if (isset($errores["error_contrasenya"])) echo "<p class='error'> " . $errores['error_contrasenya'] . "</p>" ?>
                <input type="text" name="contrasenya" id="contrasenya">
                <label for="rol">Rol: </label>
                <?php if (isset($errores["error_rol"])) echo "<p class='error'> " . $errores['error_rol'] . "</p>" ?>
                <input type="text" name="rol" id="rol">
                <a href="/login">Ya tengo usuario</a>

                <input type="submit" value="Crear usuario/a">
            </form>
        </main>
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </div>
</body>

</html>