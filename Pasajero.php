<?php
include_once("./BaseDeDatos/BaseDatos.php");

class Pasajero{

//atributos
private $nroDni;
private $nombre;
private $apellido;
private $telefono;
private $objViaje; 

//constructor
public function __construct($nombre, $apellido, $nroDni, $telefono, $objViaje){
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->nroDni = $nroDni;
    $this->telefono = $telefono;
    $this->objViaje= $objViaje;
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

public function getViaje(){
    return $this->objViaje;
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


public function setViaje($objViaje){
    $this->objViaje = $objViaje;
}

//metodo Tostring
public function __toString(){
    return "  ". $this->getNombre()." ".$this->getApellido()."\n".
            "  Nro Dni: ".$this->getNroDni()."\n".
            "  Telefono: ".$this->getTelefono()."\n";
}



}
?>