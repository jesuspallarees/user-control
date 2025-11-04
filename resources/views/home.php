<?php session_start(); 
if(!isset($_SESSION['usuario'])){
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
            <?php
                if(isset($_SESSION['usuario'])){
                    echo "<h2> Bienvenido/a " . $_SESSION['usuario'] . "</h2>";
                    echo "<h2> Tienes rol de " . $_SESSION['rol'] . "</h2>";
                }
                ?>
        </main>
        <?php require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'footer.php'; ?>
    </div>
</body>
</html>