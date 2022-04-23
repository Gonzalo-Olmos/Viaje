<?php

class ResponsableV{

//atributos
private $nroEmpleado;
private $nroLicencia;
private $nombre;
private $apellido;

//constructor
public function __construct($nroEmpleado, $nroLicencia, $nombre, $apellido){
    $this->nroEmpleado = $nroEmpleado;
    $this->nroLicencia = $nroLicencia;
    $this->nombre = $nombre;
    $this->apellido = $apellido;
}

//metodos Getters
public function getNombre(){
    return $this->nombre;
}

public function getApellido(){
    return $this->apellido;
}

public function getNroEmpleado(){
    return $this->nroEmpleado;
}

public function getNroLicencia(){
    return $this->nroLicencia;
}

//metodos Setters
public function setNombre($nombre){
    $this->nombre = $nombre;
}

public function setApellido($apellido){
    $this->apellido = $apellido;
}

public function setNroEmpleado($nroEmpleado){
    $this->nroEmpleado = $nroEmpleado;
}

public function setNroLicencia($nroLicencia){
    $this->nroLicencia = $nroLicencia;
}

//metodo Tostring
public function __toString(){
    return "\n  ". $this->getNombre()." ".$this->getApellido()."\n".
            "  Nro Empleado: ".$this->getNroEmpleado()."\n".
            "  Nro Licencia: ".$this->getNroLicencia()."\n";
}



}

?>