<?php

class Terrestes extends Viaje
{

    //atributo propio de los viajes terrestes
    private $asiento; //cama o semicama

    //constructor
    public function __construct($codigo, $destino, $cantMaxPasajeros,  $objResponsableViaje,  $importe, $idaYvuelta, $asiento)
    {
        //invocacion al constructor padre
        parent::__construct($codigo, $destino, $cantMaxPasajeros,  $objResponsableViaje,  $importe, $idaYvuelta);
        //agregamos el atributo propio
        $this->asiento=$asiento;
    }

    /**
     * Get the value of asiento
     */ 
    public function getAsiento()
    {
        return $this->asiento;
    }

    /**
     * Set the value of asiento
     */ 
    public function setAsiento($asiento)
    {
        $this->asiento = $asiento;
    }

    public function __toString()
    {
        $cadena = parent::__toString();
        $cadena .= "\n Asiento: ".$this->getAsiento();
    }


}
