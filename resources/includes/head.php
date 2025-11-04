<?php
if (preg_match('/^\/signin$/', $_SERVER["REQUEST_URI"])) {
    $nombre_pagina = "Sign In";
}else if (preg_match('/^\/panel-control$/', $_SERVER["REQUEST_URI"])) {
    $nombre_pagina = "Panel de control";
}else if (preg_match('/^\/login$/', $_SERVER["REQUEST_URI"])) {
    $nombre_pagina = "Login";
}else if (preg_match('/^\/.*$/', $_SERVER["REQUEST_URI"])) {
    $nombre_pagina = "Home";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nombre_pagina . PREPARADO_CABECERA ?></title>
    <link rel="stylesheet" href="/css/styles.css">
</head>