<?php
include_once("Viaje.php");

/**
 * Menú
 * 1) Cargar información de un viaje 
 * 2) Modificar datos del viaje (incluyendo los datos del pasajero)
 * 3)Ver datos del viaje
 */



 /**Esta funcion carga informacion de un viaje
  *@return Viaje viaje cargado
  */
function carga_viaje(){

    //pido datos del viaje
     echo("Ingrese el Codigo: \n");
    $codigo = trim(fgets(STDIN));
    echo("Ingrese Destino: \n");
    $destino = trim(fgets(STDIN));
    echo("Ingrese la cantidad máxima de pasajeros: \n");
    $cantPasajeros = trim(fgets(STDIN));  

    //Recorrido for para cargar el Arreglo Asosiativo de PASAJEROS Y Cargar La COLECCION DE PASAJEROS
    for ($i=0; $i < $cantPasajeros; $i++) { 
        //pido los datos del pasajeros
        echo ("Ingrese El nombre Ingrese El nombre del Pasajero: ".$i);
        $nombrePasajero = trim(fgets(STDIN));
        echo("Ingrese El Apellido del Pasajero: ".$i);
        $apellidoPasajero =  trim(fgets(STDIN));
        echo("Ingrese El DNI del Pasajero: ".$i);
        $dniPasajero =  trim(fgets(STDIN));
        //cargo los datos al arreglo
        $coleccion_pasajeros[$i] = Viaje::cargar_datos_pasajero($nombrePasajero, $apellidoPasajero, $dniPasajero);
}  
 
//creo una instancia Viaje 
$objViaje = new Viaje($codigo, $destino,  $cantPasajeros, $coleccion_pasajeros);
 return $objViaje;
}

$objViaje = carga_viaje();

echo $objViaje;

$coleccion_pasajeros[0] = Viaje::cargar_datos_pasajero("Gonzalo", "Olmos", 41193872);
$coleccion_pasajeros[1] = Viaje::cargar_datos_pasajero("Dario", "Olmos", 4115872);
$objViaje = new Viaje(2323, "Vlla regina",  2, $coleccion_pasajeros);


echo $objViaje;



















?>