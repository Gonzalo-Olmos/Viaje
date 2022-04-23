<?php
include_once("Viaje.php");
include_once("Pasajero.php");
include_once("ResponsableV.php");

 /**Esta funcion carga predeterminadamente informacion de un viaje Nuevo
  *@return Viaje viaje cargado
  */
 function carga_info_viaje(){
    //creo un objeto ResponsableV
    $objResponsable = new ResponsableV(23, 1111, "Mario", "Crespo");

    //creo una instancia Viaje 
    $objetoViaje = new Viaje(1123, "El bolson", 4, $objResponsable);

    //creo 4 instancias de la clase Pasajero
    $objPasajero1= new Pasajero("Juliana", "Olmos", 49412345, 2984234554);
    $objPasajero2= new Pasajero("Graciela", "Fernzandez", 37412345, 2984675494);
    $objPasajero3= new Pasajero("Gonzalo", "Olmos", 41193872, 2984906132 );
    $objPasajero4= new Pasajero("Fernando", "Olmos", 37356341, 2984922170);
    //agrego a una array los pasajeros
    $arrayPasajeros[0] =$objPasajero1;
    $arrayPasajeros[1] =$objPasajero2;
    $arrayPasajeros[2] =$objPasajero3;
    $arrayPasajeros[3] =$objPasajero4;
    //seteo el array a la coleccion de pasajeros de la clase Viaje
    $objetoViaje->setColeccion_pasajeros($arrayPasajeros);

return $objetoViaje;
}
 

/**Funcion que mofifica los datos del viaje
 *@param Viaje $objViaje
 */
function modificar_datos($objViaje){
    //obtengo la coleccion de pasajeros
    $colPasajeros = $objViaje->getColeccion_pasajeros();

//Pide los datos del viaje En caso de que se deseen modificar
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

echo("Desea Modificar un pasajero? (si/no): ");
    $respuesta=trim(fgets(STDIN));
    if ($respuesta == "si") {
        modificarDatosPasajero($objViaje);
    }

}


/**Nueva funcion que modifica los datos de un Pasajero
 * 
 */
function modificarDatosPasajero($objetoViaje){
  
      echo("Ingrese el DNI del pasajero que desea Modificar:  ");
      $dni = trim(fgets(STDIN)); 
      //invocacion al metodo para buscar en que posicion se encuentra el pasajero
     $posicionPasajero = $objetoViaje->buscarPasajero($dni);
     
        if ($posicionPasajero != -1) {
        //Pide datos del pasajero
         echo("Ingrese el Nuevo Nombre: ");
         $nombre = trim(fgets(STDIN));
         echo("Ingrese el Nuevo Apellido: ");
         $apellido = trim(fgets(STDIN));
        echo("Ingrese el Nuevo Dni: ");
        $nuevoDni = trim(fgets(STDIN));
         echo("Ingrese el Nuevo Nro de Telefono: ");
         $nroTelefono = trim(fgets(STDIN));

         $objetoViaje->modifica_datos_pasajero($nombre, $apellido, $nuevoDni, $nroTelefono, $posicionPasajero);
        }else {
        echo"\\\\Error este pasajero no se encuentra en la coleccion////";
        }
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
        echo"1)Cargar información de un viaje \n";
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