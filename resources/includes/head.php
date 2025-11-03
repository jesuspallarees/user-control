<?php
if (preg_match('/^\/.*$/', $_SERVER["REQUEST_URI"])) {
    $nombre_pagina = "Login";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nombre_pagina . PREPARADO_CABECERA ?></title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
