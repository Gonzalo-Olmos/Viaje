<?php

class Pasajero{

//atributos
private $nombre;
private $apellido;
private $nroDni;
private $telefono;

//constructor
public function __construct($nombre, $apellido, $nroDni, $telefono){
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->nroDni = $nroDni;
    $this->telefono = $telefono;
}

//metodos Getters
public function getNombre(){
    return $this->nombre;
}

public function getApellido(){
    return $this->apellido;
}

public function getNroDni(){
    return $this->nroDni;
}

public function getTelefono(){
    return $this->telefono;
}

//metodos Setters
public function setNombre($nombre){
    $this->nombre = $nombre;
}

public function setApellido($apellido){
    $this->apellido = $apellido;
}

public function setNroDni($nroDni){
    $this->nroDni = $nroDni;
}

public function setTelefono($telefono){
    $this->telefono = $telefono;
}

//metodo Tostring
public function __toString(){
    return "  ". $this->getNombre()." ".$this->getApellido()."\n".
            "  Nro Dni: ".$this->getNroDni()."\n".
            "  Telefono: ".$this->getTelefono()."\n";
}



}
?>