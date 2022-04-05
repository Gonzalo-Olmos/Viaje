<?php
include_once("Viaje.php");

//CARGA PREDETERMINADA
$coleccion_pasajeros[0] = Viaje::cargar_datos_pasajero("Gonzalo", "Olmos", 41193872);
$coleccion_pasajeros[1] = Viaje::cargar_datos_pasajero("Dario", "Olmos", 4115872);
$objViaje = new Viaje(2323, "Vlla regina",  2, $coleccion_pasajeros);
echo $objViaje;
 

 /**Esta funcion carga informacion de un viaje
  *@return Viaje viaje cargado
  */
 function carga_info_viaje(){

    //pido datos del viaje
    echo("Ingrese el Codigo: \n");
    $codigo = trim(fgets(STDIN));
    echo("Ingrese Destino: \n");
    $destino = trim(fgets(STDIN));
    echo("Ingrese la cantidad máxima de pasajeros: \n");
    $cantPasajeros = trim(fgets(STDIN)); 

    //Recorrido for para cargar el Arreglo Asosiativo de PASAJEROS Y Cargar La COLECCION DE PASAJEROS
    for($i=0; $i < $cantPasajeros; $i++) { 
        //pido los datos del pasajeros
        echo ("Ingrese El nombre Ingrese El nombre del Pasajero ".($i+1).": ");
        $nombrePasajero = trim(fgets(STDIN));
        echo("Ingrese El Apellido del Pasajero ".($i+1).": ");
        $apellidoPasajero =  trim(fgets(STDIN));
        echo("Ingrese El DNI del Pasajero ".($i+1).": ");
        $dniPasajero =  trim(fgets(STDIN));
        //cargo los datos al arreglo
        $coleccion_pasajeros[$i] = Viaje::cargar_datos_pasajero($nombrePasajero, $apellidoPasajero, $dniPasajero);
}

        //creo una instancia Viaje 
        $objetoViaje = new Viaje($codigo, $destino, $cantPasajeros, $coleccion_pasajeros);
return $objetoViaje;
}
 

/**Funcion que mofifica los datos del viaje y de los pasajeros
 *@param Viaje $objViaje
 */
function modificar_datos($objViaje){
 $cantPasajerosNuevos =0;
//obtengo la coleccion de pasajeros
$colPasajeros = $objViaje->getColeccion_pasajeros();

//Pide los datos del viaje
echo("Desea Modificar el Codigo del viaje? (si/no): ");
    $respuesta = trim(fgets(STDIN));
if ($respuesta == "si") {
    echo("Ingrese el Nuevo Codigo: \n");
    $codigo = trim(fgets(STDIN));
    $objViaje->setCodigo($codigo);
}
echo("Desea Modificar el Destino del viaje? (si/no): ");
    $respuesta = trim(fgets(STDIN));
if ($respuesta == "si") {
    echo("Ingrese el Nuevo Destino: \n");
    $destino = trim(fgets(STDIN));
    $objViaje->setDestino($destino);
}

//Consulta si desa ingresar más pasajeros

echo ("Desea ingresar más pasajeros? (si/no): ");
$respuesta = trim(fgets(STDIN));
if ($respuesta == "si"){
    echo("Cuantos pasajeros más desea agregar? ");
    $cantPasajerosNuevos = trim(fgets(STDIN));
    $limite =  $objViaje->getCantMaxPasajeros()+$cantPasajerosNuevos;

    //Agrega los nuevos pasajaros a la collecion de pasajeros
    for ($i=$objViaje->getCantMaxPasajeros(); $i < $limite; $i++) { 
        echo("Pasajero Nuevo  \n");
        echo("Ingrese el Nuevo Nombre:  \n");
        $nombre = trim(fgets(STDIN));
        echo("Ingrese el Nuevo Apellido:  \n");
        $apellido = trim(fgets(STDIN));
        echo("Ingrese el Nuevo Dni :  \n");
        $dni = trim(fgets(STDIN));
        
        
        //carga datos del pasajero nuevo
        $colPasajeros[$i]["nombre"]= $nombre ;
        $colPasajeros[$i]["apellido"]= $apellido;
        $colPasajeros[$i]["dni"]= $dni;  


        echo(" ///Pasajero Guardado con Exito\\\ \n");
        }
    }
    //pregunta si desea modificar los datos de un pasajero en especifico
    echo("Desea Modificar los datos de algun pasajero? (si/no): ");
    $respuesta = trim(fgets(STDIN));
    if ($respuesta == "si" ) {
        echo("Ingrese el Nro de Pasajero que desea Modificar (inicia desde uno): ");
        $posicion = trim(fgets(STDIN)); //acá podria hacer un metodo que verifique que exista la posición
        //Pide datos del pasajero
        echo("Ingrese el Nuevo Nombre: ");
        $nombre = trim(fgets(STDIN));
        echo("Ingrese el Nuevo Apellido: ");
        $apellido = trim(fgets(STDIN));
        echo("Ingrese el Nuevo Dni: ");
        $dni = trim(fgets(STDIN));
        //modifico el pasajero que indica el usuario
        $colPasajeros[$posicion-1]["nombre"]= $nombre ;
        $colPasajeros[$posicion-1]["apellido"]= $apellido;
        $colPasajeros[$posicion-1]["dni"]= $dni;   
    }

$objViaje->setCantMaxPasajeros($objViaje->getCantMaxPasajeros()+$cantPasajerosNuevos);
$objViaje->setColeccion_pasajeros($colPasajeros);
print_r($objViaje->getColeccion_pasajeros());

}


//MENU DE OPCIONES
do{
    $opcion = seleccionarOpcion();

    switch ($opcion) {
        case '1':
            //Cargar información de un viaje
            $objViaje = carga_info_viaje();
            break;
        case '2':
            //Modificar datos del viaje
              modificar_datos($objViaje);
            break;
        case '3':
                 //Ver datos del viaje  
                 echo $objViaje;
            break;
        case '4':
                //Salir
 			$opcion = 4;
            break;
        }
}while( $opcion != 4);



/** 
* Esta funcion permite seleccionar una opcion del menu
* @return int
*/
function seleccionarOpcion(){
    //int $opcion
    $opcion = 0;
    echo" \n";
    echo"Elija una opcion valida: \n";
    echo" \n";
    while($opcion != 4){
 	    echo"Menú de opciones \n";
        echo"1)Cargar información de un viaje   \n";
        echo"2)Modificar datos del viaje (incluyendo los datos del pasajero) \n";
        echo"3)Ver datos del viaje \n";
   	    echo"4) Salir \n";
   	    
   	    $opcion = solicitarNumeroEntre(1,4);
	    if($opcion!= 4){
            break;
        }      
    }
    return $opcion;
}

/**
 * Solicita al usuario un número en el rango [$min,$max]
 * @param int $min
 * @param int $max
 * @return int 
 */
function solicitarNumeroEntre($min, $max)
{
    //int $numero
    $numero = trim(fgets(STDIN));
    while (!is_int($numero) && !($numero >= $min && $numero <= $max)) {  //La primer negacion creemos que no es correcta
        echo "Debe ingresar un número entre " . $min . " y " . $max . ": ";
        $numero = trim(fgets(STDIN));
    }
    return $numero;
}


?>