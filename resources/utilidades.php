<?php
function leer_json(string $ruta_json): array
{
    $contenido = file_get_contents($ruta_json);
    $datos = json_decode($contenido, true);
    if ($datos === null) {
        return [];
    }
    return $datos;
}

function escribir_json_usuarios(string $ruta_json, Usuario $usuario): void
{
    $lista_usuarios = leer_json($ruta_json);
    $lista_usuarios[] = (array) $usuario;
    file_put_contents($ruta_json, json_encode($lista_usuarios, JSON_PRETTY_PRINT));
}