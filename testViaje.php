<?php
include_once("Viaje.php");
include_once("Pasajero.php");
include_once("ResponsableV.php");
include_once("Terrestres.php");
include_once("Aereos.php");

 /**Esta funcion carga predeterminadamente informacion de un viaje Nuevo
  *@return Viaje viaje cargado
  */
 function carga_info_viaje(){
    //creo un objeto ResponsableV
    $objResponsable = new ResponsableV(23, 1111, "Mario", "Crespo");

    //creo una instancia Viaje 
    $objetoViaje = new Viaje(1123, "El bolson", 10, $objResponsable, 15000, "si");

    //creo 5 instancias de la clase Pasajero
    $objPasajero1= new Pasajero("Juliana", "Olmos", 59512355, 2985235555);
    $objPasajero2= new Pasajero("Graciela", "Fernzandez", 37512355, 2985675595);
    $objPasajero3= new Pasajero("Gonzalo", "Olmos", 51193872, 2985906132 );
    $objPasajero5= new Pasajero("Fernando", "Olmos", 37356351, 2985922170);
    //agrego a un array los pasajeros
    $arrayPasajeros[0] =$objPasajero1;
    $arrayPasajeros[1] =$objPasajero2;
    $arrayPasajeros[2] =$objPasajero3;
    $arrayPasajeros[3] =$objPasajero5;
    //seteo el array a la coleccion de pasajeros de la clase Viaje
    $objetoViaje->setColeccion_pasajeros($arrayPasajeros);

    //Venta de pasajes
    echo "Venta de Pasaje Terrestre: \n";
    $objViajeTerrestre = new Terrestres(67585, "Villa la angostura", 8,  $objResponsable,  50000, "si", "cama");
    $importe = $objViajeTerrestre->venderPasaje($objPasajero1);
    echo "Importe de venta: $".$importe;
    echo " \n";
    echo "Venta de Pasaje Aereo: \n";
    $objViajeAereo= new Aereos(67585, "Villa la angostura", 8,  $objResponsable,  50000, "si", 998, "primera clase", "Aerolineas argentina", 5);
    $importe = $objViajeAereo->venderPasaje($objPasajero2);
    echo "Importe de venta: $".$importe;

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
            //submenu viajes

            break;
        case '2':
            //submenu empresas
          
            break;
        case '3':
            //submenu responsables
                
            break;
        case '4':
            //submenu pasajeros
               
           break;
        case '5':
            //Salir
 			$opcion = 5;
            break;
        }
}while( $opcion != 5);


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
    while($opcion != 5){
 	    echo"Menú de opciones \n";
        /**Cargar una empresa */
        echo"1)Viajes\n"; //submenu viajes
        echo"2)Empresas\n"; //submenu empresas
        echo"3)Responsables\n"; //submenu responsables
   	    echo"4)Pasajeros \n"; //submenu pasajeros
        echo"5)Salir \n";
   	    
   	    $opcion = solicitarNumeroEntre(1,5);
	    if($opcion!= 5){
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
    while (!is_int($numero) && !($numero >= $min && $numero <= $max)) { 
        echo "Debe ingresar un número entre " . $min . " y " . $max . ": ";
        $numero = trim(fgets(STDIN));
    }
    return $numero;
}


/** 
* Esta funcion permite seleccionar una opcion del submenu viajes
* @return int
*/
function selectOpcionViaje(){
    //int $opcion
    $opcion = 0;
  
    while($opcion != 5){
 	  
        echo"1)Cargar un nuevo Viaje\n"; 
        echo"2)Modificar un Viaje\n"; 
        echo"3)Eliminar un Viaje\n"; 
   	    echo"4)Listar Viajes\n";
        echo"5)Salir \n";
   	    
   	    $opcion = solicitarNumeroEntre(1,5);
	    if($opcion!= 5){
            break;
        }      
    }
    return $opcion;
}

/** 
* Esta funcion permite seleccionar una opcion del submenu Responsables
* @return int
*/
function selectOpcionResponsable(){
    //int $opcion
    $opcion = 0;
  
    while($opcion != 5){
 	  
        echo"1)Cargar un nuevo Responsable\n"; 
        echo"2)Modificar un Responsable\n"; 
        echo"3)Eliminar un Responsable\n"; 
   	    echo"4)Listar Responsables\n";
        echo"5)Salir \n";
   	    
   	    $opcion = solicitarNumeroEntre(1,5);
	    if($opcion!= 5){
            break;
        }      
    }
    return $opcion;
}

/** 
* Esta funcion permite seleccionar una opcion del submenu Pasajeros
* @return int
*/
function selectOpcionPasajero(){
    //int $opcion
    $opcion = 0;
  
    while($opcion != 5){
 	  
        echo"1)Cargar un nuevo Pasajero\n"; 
        echo"2)Modificar un Pasajero\n"; 
        echo"3)Eliminar un Pasajero\n"; 
   	    echo"4)Listar Pasajeros\n";
        echo"5)Salir \n";
   	    
   	    $opcion = solicitarNumeroEntre(1,5);
	    if($opcion!= 5){
            break;
        }      
    }
    return $opcion;
}

/** 
* Esta funcion permite seleccionar una opcion del submenu Empresas
* @return int
*/
function selectOpcionEmpresa(){
    //int $opcion
    $opcion = 0;
  
    while($opcion != 5){
 	  
        echo"1)Cargar una nueva Empresa\n"; 
        echo"2)Modificar una Empresa\n"; 
        echo"3)Eliminar una Empresa\n"; 
   	    echo"4)Listar Empresas\n";
        echo"5)Salir \n";
   	    
   	    $opcion = solicitarNumeroEntre(1,5);
	    if($opcion!= 5){
            break;
        }      
    }
    return $opcion;
}

?>