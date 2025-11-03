<?php
class Usuario{
    protected string $usuario;
    protected string $contrasenya; 
    protected string $rol; 

    function __construct(string $usuario, string $contrasenya, string $rol)
    {
        $this->usuario = $usuario;
        $this->contrasenya = $contrasenya;   
        $this->rol = $rol;   
    }
}