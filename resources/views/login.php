<!DOCTYPE html>
<html lang="es">
<?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'head.php'; ?>

<body>
    <div class="contenedor">
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'header.php'; ?>
        <main>
            <form method="post">
                <h2>Login</h2>
                <label for="usuario">Usuario: </label>
                <input type="text" name="usuario" id="usuario">
                <label for="contrasenya">Contraseña: </label>
                <input type="text" name="contrasenya" id="contrasenya">
                <a href="/signin">Nuevo usuario</a>
                <input type="submit" value="Acceder">
            </form>
        </main>
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </div>
</body>

</html>