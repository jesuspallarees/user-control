<?php
if (preg_match('/^\/.*$/', $_SERVER["REQUEST_URI"])) {
    $nombre_pagina = "Login";
}
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nombre_pagina . $preparado_cabecera ?></title>
    <link rel="stylesheet" href="/css/styles.css">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    />
</head>
