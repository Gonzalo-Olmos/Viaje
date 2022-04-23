<?php

class Viaje{

    //atributos de la clase
    private $codigo;
    private $destino; 
    private $cantMaxPasajeros;
    private $coleccion_pasajeros=[];
    private $objResponsableViaje;

    //Constructor
    public function __construct($codigo, $destino, $cantMaxPasajeros,  $objResponsableViaje ){
        $this->codigo = $codigo;
        $this->destino = $destino;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->objResponsableViaje = $objResponsableViaje;
    }
    //Getters
    public function getCodigo(){
        return $this->codigo;
    }

    public function getDestino(){
        return $this->destino;
    }

    public function getCantMaxPasajeros(){
        return $this->cantMaxPasajeros;
    }

    public function getColeccion_pasajeros(){
        return $this->coleccion_pasajeros;
    }

    public function getResponsableViaje(){
        return $this->objResponsableViaje;
    }


    //Setters
    public function setCodigo($codigo){
        $this->codigo = $codigo;
    }

    public function setDestino($destino){
        $this->destino = $destino;
    }

    public function setCantMaxPasajeros($cantMaxPasajeros){
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }

    public function setColeccion_pasajeros($coleccion_pasajeros){
        $this->coleccion_pasajeros = $coleccion_pasajeros;
    }
    public function setResponsableViaje($responsableViaje){
       $this->responsableViaje = $responsableViaje;
    }

    //toString
    public function __toString(){
        return "\n Codigo: ".$this->getCodigo().
        "\n destino: ".$this->getDestino().
        "\n cantMaxPasajeros: ".$this->getCantMaxPasajeros().
        "\n Responsable Del Viaje: ".$this->getResponsableViaje().
        "\n coleccion_pasajeros:\n".$this->mostrar_coleccion_pasajero(); 
    }       


    /**
     * Funcion que setea Los datos de un Pasajero Especifico
     */
    public function modifica_datos_pasajero($nombre, $apellido, $nuevoDni, $nroTelefono, $pos){
        $coleccion_pasajeros = $this->getColeccion_pasajeros();

        $coleccion_pasajeros[$pos]->setNombre($nombre);
        $coleccion_pasajeros[$pos]->setApellido($apellido);
        $coleccion_pasajeros[$pos]->setNroDni($nuevoDni);
        $coleccion_pasajeros[$pos]->setTelefono($nroTelefono);

        $this->setColeccion_pasajeros($coleccion_pasajeros);
    }

public function agregar_pasajero(){

}


/**
 * esta funcion busca un pasajero mediante el dni, si lo encuentra retorna la posicion del objeto sino retorna -1
 * @param $dniPasajero
 * @return int
 */
public function buscarPasajero($dniPasajero){

    $arrayPasajeros = $this->getColeccion_pasajeros();
    $i=0;
    $posicion=-1;
    $seEncontro=false;
    while($i<count($arrayPasajeros) && !$seEncontro){
       $objPasajero = $arrayPasajeros[$i];
        $seEncontro = ($objPasajero->getNroDni() == $dniPasajero);
       if ($seEncontro) {
            $posicion= $i;
       }
        $i++;
    }
return $posicion;
}



/**Está funcion hace un recorrido al arreglo para mostrar la informacion del arreglo
 */
public function mostrar_coleccion_pasajero(){
$coleccionPasajeros = [];
$coleccionPasajeros = $this->getColeccion_pasajeros();
$cadena = " ";
 for ($i=0; $i < count($coleccionPasajeros) ; $i++){ 
     $objPasajero = $coleccionPasajeros[$i];
    $cadena = $cadena."\n---- Pasajero ".($i+1)." ----: \n"; 
    $cadena = $cadena . $objPasajero;
    
    } 
    return $cadena;
}
 
    

}

























?>