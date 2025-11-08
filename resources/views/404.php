<!DOCTYPE html>
<html lang="en">
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
            <h1 class="e-404">404</h1>
            <h2>La ruta solicitada no existe o no está disponible 😞</h2>
        </main>
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </div>
</body>

</html>