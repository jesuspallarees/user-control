<?php
session_start();
// if(isset($_SESSION['usuario'])){ ** Por si las moscas, hace falta revisar bien antes de activar esto.
//     if(isset($_SESSION['rol']) && $_SESSION['rol'] != "admin"){
//         header("Location:/login");
//         exit();
//     }
// }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errores = [];
    if (isset($_POST["usuario"])) {
        $lista_usuarios = leer_json(RUTA_USUARIOS);
        $usuario = htmlspecialchars($_POST["usuario"]);

        if (!isset($_POST["rol"])) {
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

<body>
    <div class="contenedor">
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php'; ?>
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'navigation.php'; ?>
        <main>
            <form method="post">
                <?php if (count($errores) == 0) echo "<p class='valido'>Se ha modificado de forma correcta al usuario</p>" ?>
                <label for="usuario">Nombre de usuario:</label>
                <?php if (isset($errores["error_usuario_no_encontrado"])) echo "<p class='error'> " . $errores['error_usuario_no_encontrado'] . "</p>" ?>
                <input type="text" name="usuario" id="usuario">
                <label for="rol">Rol:</label>
                <?php if (isset($errores["error_rol_vacio"])) echo "<p class='error'> " . $errores['error_rol_vacio'] . "</p>" ?>
                <?php if (isset($errores["error_rol_invalido"])) echo "<p class='error'> " . $errores['error_rol_invalido'] . "</p>" ?>
                <input type="text" name="rol" id="rol">
                <label for="encabezado">Color encabezado:</label>
                <input type="color" name="encabezado" id="encabezado">
                <label for="fondo">Color fondo:</label>
                <input type="color" name="fondo" id="fondo">
                <label for="pie">Color pie:</label>
                <input type="color" name="pie" id="pie">
                <input type="submit" value="Modificar usuario">
            </form>
        </main>
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </div>
</body>

</html>