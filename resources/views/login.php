<?php
$errores = [];
$lista_usuarios = leer_json(RUTA_USUARIOS);
$valido = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["usuario"]) && isset($_POST["contrasenya"])) {
        $usuario = htmlspecialchars($_POST["usuario"]);
        $contrasenya = $_POST["contrasenya"];

        $usuario_encontrado = null;
        foreach ($lista_usuarios as $usuario_lista) {
            if ($usuario_lista['usuario'] === $usuario) {
                $usuario_encontrado = $usuario_lista;
                break;
            }
        }

        if ($usuario_encontrado !== null) {
            $valido = password_verify($contrasenya, $usuario_encontrado['contrasenya']);

            if (!$valido) {
                $errores['error_contrasenya'] = "Contraseña incorrecta";
            } else {
                session_start();
                if (
                    empty($_SESSION['csrf_token']) || empty($_SESSION['csrf_token_time']) ||
                    (time() - $_SESSION['csrf_token_time']) > VIDA_TOKEN_CSRF
                ) {

                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                    $_SESSION['csrf_token_time'] = time();
                }
                $_SESSION["usuario"] = $usuario_encontrado['usuario'];
                $_SESSION["contrasenya"] = $usuario_encontrado['contrasenya'];
                $_SESSION["rol"] = $usuario_encontrado['rol'];
                header("Location:/");
                exit();
            }
        } else {
            $errores['error_usuario'] = "No se ha encontrado el usuario";
        }
    } else {
        $errores['error_formulario'] = "Usuario y contraseña son requeridos";
    }
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
                <?php if (count($errores) != 0) echo "<p class='error'>Usuario y/o contraseña incorrectos</p>" ?>
                <h2>Login</h2>
                <label for="usuario">Usuario/a: </label>
                <input type="text" name="usuario" id="usuario">
                <label for="contrasenya">Contraseña: </label>
                <input type="text" name="contrasenya" id="contrasenya">
                <a href="/signin">Nuevo usuario/a</a>
                <input type="submit" value="Acceder">
            </form>
        </main>
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </div>
</body>

</html>