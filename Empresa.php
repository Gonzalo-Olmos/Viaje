<?php

class Empresa{

//atributos
private $idempresa;
private $enombre;
private $edireccion;

//constructor
public function __construct(){
    $this->idempresa = "";
    $this->enombre = "";
    $this->edireccion = "";
}

public function cargar($idempresa, $enombre, $edireccion){

    $this->setIdEmpresa($idempresa);
    $this->setEnombre($enombre);
    $this->setEdireccion($edireccion);
}

//metodos Getters
public function getIdEmpresa(){
    return $this->idempresa;
}

public function getEnombre(){
    return $this->enombre;
}

public function getEdireccion(){
    return $this->edireccion;
}

//metodos Setters
public function setIdEmpresa($idempresa){
    $this->idempresa = $idempresa;
}

public function setEnombre($enombre){
    $this->enombre = $enombre;
}

public function setEdireccion($edireccion){
    $this->edireccion = $edireccion;
}

//metodo Tostring
public function __toString(){
    return " Id Empresa: ". $this->getIdEmpresa()."\n".
            " Nombre Empresa: ".$this->getEnombre()."\n".
            " Direccion Empresa: ".$this->getEdireccion()."\n";
}

}
?>