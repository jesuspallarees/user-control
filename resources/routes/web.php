<?php
declare(strict_types=1);
error_reporting(E_ALL & ~E_WARNING);
error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 1); // 0 para no mostrar ni un solo error


if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    $_SESSION = array();

    if (ini_get("session.use_cookies")) { // Si quiero eliminar la sesión, también romper las cookies!
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();

    header("Location: /login");
    exit();
}

if (!isset($_SERVER['REQUEST_URI'])) {
    $peticion = '/';
} else {
    $peticion = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
}

$lista_blanca = [ // Cuando no hay una sesión iniciada
    '/' => 'home.php',
    '/login' => 'login.php',
    '/signin' => 'signin.php',
];

$lista_blanca_admin = [
    '/' => 'home.php',
    '/panel-control' => 'panel-control.php'
];

$lista_blanca_usuario = [
    '/' => 'home.php',
];

$lista_blanca_invitado = [
    '/' => 'home.php',
];

$estructura_carpetas = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
$rol;

session_start();

if (isset($_SESSION['usuario'])) {
    if (isset($_SESSION['rol'])) {
        $rol = $_SESSION['rol'];
        if ($rol === "admin") {
            if (array_key_exists($peticion, $lista_blanca_admin)) {
                require $estructura_carpetas . $lista_blanca_admin[$peticion];
            } else {
                http_response_code(404);
                require $estructura_carpetas . '404.php';
            }
        } else if ($rol === "usuario") {
            if (array_key_exists($peticion, $lista_blanca_usuario)) {
                require $estructura_carpetas . $lista_blanca_usuario[$peticion];
            } else {
                http_response_code(404);
                require $estructura_carpetas . '404.php';
            }
        } else if ($rol === "invitado") {
            if (array_key_exists($peticion, $lista_blanca_invitado)) {
                require $estructura_carpetas . $lista_blanca_invitado[$peticion];
            } else {
                http_response_code(404);
                require $estructura_carpetas . '404.php';
            }
        }
    }
} else {
    if (!isset($_SERVER['REQUEST_URI'])) {
        $peticion = '/';
    } else {
        $peticion = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    if (array_key_exists($peticion, $lista_blanca)) {
        require $estructura_carpetas . $lista_blanca[$peticion];
    } else {
        http_response_code(404);
        require $estructura_carpetas . '404.php';
    }
}
