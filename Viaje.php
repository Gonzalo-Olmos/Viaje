<?php

class Viaje{

    //atributos de la clase
    private $codigo;
    private $destino; 
    private $cantMaxPasajeros;
    private $coleccion_pasajeros=[];

  
    //Constructor
    public function __construct($codigo, $destino, $cantMaxPasajeros, $coleccion_pasajeros ){
        $this->codigo = $codigo;
        $this->destino = $destino;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->coleccion_pasajeros = $coleccion_pasajeros;
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

    //toString
    public function __toString(){
        return "\n Codigo: ".$this->getCodigo()." \n  destino: ".$this->getDestino()."\n cantMaxPasajeros: ".$this->getCantMaxPasajeros()." \n coleccion_pasajeros:  \n".$this->mostrar_coleccion_pasajero();
    }       
    /** Esta función permite cargar los datos de un pasajero en un arreglo asociativo, retorna un arreglo cargado
     * @param String $nombre
     * @param String $apellido
     * @param int $dni
     * @return array $pasajero
     */
    public static function cargar_datos_pasajero($nombre, $apellido, $dni ){
        $pasajero = ["nombre"=>$nombre,"apellido"=>$apellido,"dni"=>$dni ];
        return $pasajero;
    }


    /**Esta funcion Modifica los datos de un Objeto Viaje. (incluyendo los datos del pasajero)
 * @param Viaje $codigo
 * @param $destino
 * @param array $coleccion_pasajeros
 */
/* public function modificar_info_viaje($coleccion_pasajeros){
    //Modifica los datos del viaje
   

    $this->setColeccion_pasajeros($coleccion_pasajeros);

    
} */

/**Está funcion hace un recorrido al arreglo para mostrar la informacion del arreglo
 */
public function mostrar_coleccion_pasajero(){
$coleccionPasajeros = [];
$coleccionPasajeros = $this->getColeccion_pasajeros();

 for ($i=0; $i < count($coleccionPasajeros) ; $i++) { 
    echo("--- Pasajero ".($i+1)." ---: \n");
    echo "Nombre: ".$coleccionPasajeros[$i]["nombre"]." \n";
    echo "Apellido: ".$coleccionPasajeros[$i]["apellido"]." \n";
    echo "Dni: ".$coleccionPasajeros[$i]["dni"]." \n";
} 
   

}

    
 /*    public function cargar_pasajeros($pasajero){
        for ($i=0; $i < $this->cantMaxPasajeros ; $i++) { 
        $coleccion_pasajeros[$i]= $pasajero;
        }
    } */
    



}

























?>