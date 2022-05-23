<?php

class Viaje
{

    //atributos de la clase
    private $codigo;
    private $destino;
    private $cantMaxPasajeros;
    private $coleccion_pasajeros = [];
    private $objResponsableViaje;
    private $importe;
    private $idaYvuelta; // si o no

    //Constructor
    public function __construct($codigo, $destino, $cantMaxPasajeros,  $objResponsableViaje, $importe, $idaYvuelta)
    {
        $this->codigo = $codigo;
        $this->destino = $destino;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->objResponsableViaje = $objResponsableViaje;
        $this->importe = $importe;
        $this->idaYvuelta = $idaYvuelta;
    }
    //Getters
    public function getCodigo()
    {
        return $this->codigo;
    }

    public function getDestino()
    {
        return $this->destino;
    }

    public function getCantMaxPasajeros()
    {
        return $this->cantMaxPasajeros;
    }

    public function getColeccion_pasajeros()
    {
        return $this->coleccion_pasajeros;
    }

    public function getResponsableViaje()
    {
        return $this->objResponsableViaje;
    }
    public function getIdaYvuelta() 
    {
        return $this->idaYvuelta;
    }
    public function getImporte()
    {
        return $this->importe;
    }


    //Setters
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;
    }

    public function setDestino($destino)
    {
        $this->destino = $destino;
    }

    public function setCantMaxPasajeros($cantMaxPasajeros)
    {
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }

    public function setColeccion_pasajeros($coleccion_pasajeros)
    {
        $this->coleccion_pasajeros = $coleccion_pasajeros;
    }
    public function setResponsableViaje($responsableViaje)
    {
        $this->responsableViaje = $responsableViaje;
    }
    public function setIdaYvuelta($idaYvuelta)
    {
        $this->idaYvuelta = $idaYvuelta;
    }
    public function setImporte($importe)
    {
        $this->importe = $importe;
    }

    //toString
    public function __toString()
    {
        return "\n Codigo: " . $this->getCodigo() .
            "\n destino: " . $this->getDestino() .
            "\n cantMaxPasajeros: " . $this->getCantMaxPasajeros() .
            "\n Responsable Del Viaje: " . $this->getResponsableViaje() .
            "\n coleccion_pasajeros:\n" . $this->mostrar_coleccion_pasajero().
            "\n Importe:\n" . $this->getImporte().
            "\n idaYvuelta:\n" . $this->getIdaYvuelta();
    }


    /**
     * Funcion que setea Los datos de un Pasajero Especifico
     */
    public function modifica_datos_pasajero($nombre, $apellido, $dni, $nroTelefono, $pos)
    {
        $coleccion_pasajeros = $this->getColeccion_pasajeros();

        $coleccion_pasajeros[$pos]->setNombre($nombre);
        $coleccion_pasajeros[$pos]->setApellido($apellido);
        $coleccion_pasajeros[$pos]->setNroDni($dni);
        $coleccion_pasajeros[$pos]->setTelefono($nroTelefono);

        $this->setColeccion_pasajeros($coleccion_pasajeros);
    }


    /**
     * esta funcion busca un pasajero mediante el dni, si lo encuentra retorna la posicion del objeto sino retorna -1
     * @param $dniPasajero
     * @return int
     */
    public function buscarPasajero($dniPasajero)
    {

        $arrayPasajeros = $this->getColeccion_pasajeros();
        $i = 0;
        $posicion = -1;
        $seEncontro = false;
        while ($i < count($arrayPasajeros) && !$seEncontro) {
            $objPasajero = $arrayPasajeros[$i];
            $seEncontro = ($objPasajero->getNroDni() == $dniPasajero);
            if ($seEncontro) {
                $posicion = $i;
            }
            $i++;
        }
        return $posicion;
    }

    /**
     * Hacer una funcion para agregar un pasajero a la coleccion 
     * @param Pasajero $unPasajero
     */
    public function agregarPasajero($unPasajero){ 
        $coleccionPasajeros = $this->getColeccion_pasajeros();
        $coleccionPasajeros[]= $unPasajero;
    }


    /**Está funcion hace un recorrido al arreglo para mostrar la informacion del arreglo
     * @return String
     */
    public function mostrar_coleccion_pasajero()
    {
        $coleccionPasajeros = [];
        $coleccionPasajeros = $this->getColeccion_pasajeros();
        $cadena = " ";
        for ($i = 0; $i < count($coleccionPasajeros); $i++) {
            $objPasajero = $coleccionPasajeros[$i];
            $cadena = $cadena . "\n---- Pasajero " . ($i + 1) . " ----: \n";
            $cadena = $cadena . $objPasajero;
        }
        return $cadena;
    }

    /**
     * Metodo que registra la venta de un viaje al pasajero que es recibido por parámetro.
     * @param Pasajero $pasajero
     * @return double 
     */
    public function venderPasaje($unPasajero){
        
        if($this->hayPasajesDisponibles()){
            #Se realiza la venta del viaje
            $this->agregarPasajero($unPasajero);

            $importe = $this->getImporte();
            if($this->getIdaYvuelta()=="si"){
                #si es de ida y vuelta el importe se incrementa un %50
                $importe += ($importe * 50)/100; 
            }  
             
        }else{
            $importe = null;
        }
        return $importe;
    }
    
    /**
     * Metodo que retorna verdadero si la cantidad de pasajeros del viaje es menor a la cantidad máxima de pasajeros y falso caso contrario.
     *@return bool si hay pasajes disponibles
     */
    public function hayPasajesDisponibles(){

        $res=false;
        
        $cantPasajeros = count($this->getColeccion_pasajeros());
        
        if($cantPasajeros < $this->getCantMaxPasajeros()){
            $res=true;
        }

       return $res;
    }

  

}
