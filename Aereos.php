<?php
include_once("./BaseDeDatos/BaseDatos.php");

class Aereos extends Viaje
{

    //atributos propios de los viajes Aereos
    private $numerVuelo;
    private $categoriaAsiento; //primera clase o normal
    private $nombreAerolinea;
    private $cantEscalas;

    //constructor
    public function __construct(
        $codigo,
        $destino,
        $cantMaxPasajeros,
        $objResponsableViaje,
        $importe,
        $idaYvuelta,
        $numerVuelo,
        $categoriaAsiento,
        $nombreAerolinea,
        $cantEscalas
    ){
        //invocacion al constructor padre
        parent::__construct($codigo, $destino, $cantMaxPasajeros,  $objResponsableViaje, $importe, $idaYvuelta);
        //agregamos los atributos propios
        $this->numerVuelo = $numerVuelo;
        $this->categoriaAsiento = $categoriaAsiento;
        $this->nombreAerolinea = $nombreAerolinea;
        $this->cantEscalas = $cantEscalas;
    }

    /**
     * Get the value of numerVuelo
     */
    public function getNumerVuelo()
    {
        return $this->numerVuelo;
    }

    /**
     * Set the value of numerVuelo
     */
    public function setNumerVuelo($numerVuelo)
    {
        $this->numerVuelo = $numerVuelo;
    }

    /**
     * Get the value of categoriaAsiento
     */
    public function getCategoriaAsiento()
    {
        return $this->categoriaAsiento;
    }

    /**
     * Set the value of categoriaAsiento
     */
    public function setCategoriaAsiento($categoriaAsiento)
    {
        $this->categoriaAsiento = $categoriaAsiento;
    }

    /**
     * Get the value of nombreAerolinea
     */
    public function getNombreAerolinea()
    {
        return $this->nombreAerolinea;
    }

    /**
     * Set the value of nombreAerolinea
     */
    public function setNombreAerolinea($nombreAerolinea)
    {
        $this->nombreAerolinea = $nombreAerolinea;
    }

    /**
     * Get the value of cantEscalas
     */
    public function getCantEscalas()
    {
        return $this->cantEscalas;
    }

    /**
     * Set the value of cantEscalas
     */
    public function setCantEscalas($cantEscalas)
    {
        $this->cantEscalas = $cantEscalas;
    }

    //to String
    public function __toString()
    {
        $cadena = parent::__toString();
        $cadena .=  "\n Numero Vuelo: " . $this->getNumerVuelo() .
            "\n Categoria Asiento: " . $this->getCategoriaAsiento() .
            "\n Nombre Aerolinea: " . $this->getNombreAerolinea() .
            "\n Cantidad de Escalas: " . $this->getCantEscalas();
    }


    /**
     * Metodo extendido de la clase Viaje
     * @param Pasajero $unPasajero
     * @return double
     */
    public function venderPasaje($unPasajero)
    {
        $importe = parent::venderPasaje($unPasajero);

        if ($importe != null && $this->getCategoriaAsiento="primera clase") {
            if ($this->getCantEscalas() > 0) {
                #el importe se incrementa un 60%
                $importe += ($importe * 60) / 100 ; 
            }else {
                #el importe se incrementa un 40%
                $importe += ($importe * 40) / 100 ; 
            }
        }
        
        return $importe;
    }

}


