<?php
class Usuario{
    public string $usuario;
    public string $contrasenya; 
    public string $rol; 

    function __construct(string $usuario, string $contrasenya, string $rol)
    {
        $this->usuario = $usuario;
        $this->contrasenya = $contrasenya;   
        $this->rol = $rol;   
    }
}