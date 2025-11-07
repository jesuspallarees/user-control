<?php
session_start();

if(!isset($_SESSION['usuario']) || !isset($_SESSION['rol']) || $_SESSION['rol'] != "admin"){
    header("Location: login.php");
    exit();
}

if (empty($_SESSION['csrf_token']) || empty($_SESSION['tiempo_csrf_token']) || 
    (time() - $_SESSION['tiempo_csrf_token']) > VIDA_TOKEN_CSRF) {
    
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    $_SESSION['tiempo_csrf_token'] = time(); 
}

$errores = [];
$exito = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Solicitud no válida. Token CSRF no coincide.');
    }
    
    if (isset($_POST["usuario"])) {
        $lista_usuarios = leer_json(RUTA_USUARIOS);
        $usuario = htmlspecialchars($_POST["usuario"]);

        if (empty($_POST["rol"])) {
            $errores["error_rol_vacio"] = "Introduzca un rol, por favor";
        } else {
            $rol = $_POST["rol"];
            if (!in_array($rol, ["admin", "usuario", "invitado"])) {
                $errores["error_rol_invalido"] = "El rol debe de ser admin, usuario o invitado";
            }
        }

        if (count($errores) == 0) {
            $usuario_encontrado = null;
            $usuario_modificado = null;
            foreach ($lista_usuarios as $indice => $usuario_lista) {
                if ($usuario_lista['usuario'] === $usuario) {
                    $usuario_encontrado = $usuario_lista;
                    $usuario_modificado = new Usuario($usuario, $usuario_encontrado["contrasenya"], $rol);
                    unset($lista_usuarios[$indice]);
                    break;
                }
            }

            if ($usuario_modificado != null) {
                $lista_usuarios = array_values($lista_usuarios);
                $lista_usuarios[] = (array) $usuario_modificado;
                escribir_json_multiples_usuarios(RUTA_USUARIOS, $lista_usuarios);

                if (isset($_POST["modificar_usuario"])) {
                    setcookie('color_encabezado_' . $usuario, $_POST["encabezado"], time() + 30 * 24 * 3600, "/");
                    setcookie('color_fondo_' . $usuario, $_POST["fondo"], time() + 30 * 24 * 3600, "/");
                    setcookie('color_pie_' . $usuario, $_POST["pie"], time() + 30 * 24 * 3600, "/");

                    $_COOKIE["color_encabezado"] = $_POST["encabezado"];
                    $_COOKIE["color_fondo"] = $_POST["fondo"];
                    $_COOKIE["color_pie"] = $_POST["pie"];
                }
                
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                $_SESSION['tiempo_csrf_token'] = time();
                $exito = true;
                $_POST = array(); 
                
            } else {
                $errores["error_usuario_no_encontrado"] = "No se ha encontrado ningún usuario con ese nombre";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php'; ?>
<style>
    header {
        background-color: <?= $_COOKIE['color_encabezado_' . $_SESSION['usuario']] ?? 'lightseagreen' ?>;
    }

    .navegacion {
        background-color: <?= $_COOKIE['color_encabezado_' . $_SESSION['usuario']] ?? 'lightseagreen' ?>;
    }

    .contenedor {
        background-color: <?= $_COOKIE['color_fondo_' . $_SESSION['usuario']] ?? 'lightblue' ?>;
    }

    footer {
        background-color: <?= $_COOKIE['color_pie_' . $_SESSION['usuario']] ?? 'lightseagreen' ?>;
    }

    input[type="submit"] {
        background-color: <?= $_COOKIE['color_encabezado_' . $_SESSION['usuario']] ?? 'lightseagreen' ?>;
    }
</style>

<body>
    <div class="contenedor">
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php'; ?>
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'navigation.php'; ?>
        <main>
            <form method="post">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                
                <?php if ($exito && count($errores) == 0){ ?>
                    <p class='valido'>Se ha modificado de forma correcta al usuario. Los cambios se realizarán en la siguiente sesión.</p>
                <?php } ?>
                
                <label for="usuario">Nombre de usuario:</label>
                <?php if (isset($errores["error_usuario_no_encontrado"])) echo "<p class='error'> " . $errores['error_usuario_no_encontrado'] . "</p>" ?>
                <input type="text" name="usuario" id="usuario" value="<?php echo (isset($errores) && count($errores) > 0 && isset($_POST['usuario'])) ? htmlspecialchars($_POST['usuario']) : ''; ?>">
                <label for="rol">Rol:</label>
                <?php if (isset($errores["error_rol_vacio"])) echo "<p class='error'> " . $errores['error_rol_vacio'] . "</p>" ?>
                <?php if (isset($errores["error_rol_invalido"])) echo "<p class='error'> " . $errores['error_rol_invalido'] . "</p>" ?>
                <input type="text" name="rol" id="rol" value="<?php echo (isset($errores) && count($errores) > 0 && isset($_POST['rol'])) ? htmlspecialchars($_POST['rol']) : ''; ?>">
                <label for="encabezado">Color encabezado:</label>
                <input type="color" name="encabezado" id="encabezado" value="<?php echo $_COOKIE['color_encabezado_' . $_SESSION['usuario']] ?? '#20b2aa' ?>">
                <label for="fondo">Color fondo:</label>
                <input type="color" name="fondo" id="fondo" value="<?php echo $_COOKIE['color_fondo_' . $_SESSION['usuario']] ?? '#add8e6' ?>">
                <label for="pie">Color pie:</label>
                <input type="color" name="pie" id="pie" value="<?php echo $_COOKIE['color_pie_' . $_SESSION['usuario']] ?? '#20b2aa' ?>">
                <input type="submit" name="modificar_usuario" value="Modificar usuario">
            </form>
        </main>
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </div>
</body>
</html>