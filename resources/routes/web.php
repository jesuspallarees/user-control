<?php

declare(strict_types=1);

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

$lista_blanca = [
    '/' => 'home.php',
    '/login' => 'login.php',
    '/signin' => 'signin.php'
];

$estructura_carpetas = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR;
if (array_key_exists($peticion, $lista_blanca)) {
    require $estructura_carpetas . $lista_blanca[$peticion];
} else {
    http_response_code(404);
    require $estructura_carpetas . '404.php';
}
