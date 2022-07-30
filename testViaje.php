<?php
/* include_once("Viaje.php"); */
include_once("Pasajero.php");
include_once("ResponsableV.php");
include_once("Empresa.php");

/**Esta funcion carga predeterminadamente informacion de un viaje Nuevo
 *@return Viaje viaje cargado
 */
/*   function carga_info_viaje(){
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
  */

/**Funcion que mofifica los datos del viaje
 *@param Viaje $objViaje
 */
/* function modificar_datos($objViaje){
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
 */

/**Nueva funcion que modifica los datos de un Pasajero
 * 
 */
/* function modificarDatosPasajero($objetoViaje){
  
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

 */


/**
 * Funcion que carga un viaje a la base de datos
 */
function cargarViaje()
{
    $objViaje = new Viaje();
    $objEmpresa = new Empresa();
    $objResponsable = new ResponsableV();
    //antes de cargar verifico que hayan empresas y responsables cargados

    if (verificarEmpresasCargadas() == false) {
        echo ("!No hay ninguna Empresa Cargada! \n Cargue al menos una, antes de cargar un viaje");
        selectOpcionEmpresa();
    }
    if (verificarResponsablesCargados() == false) {

        echo ("!No hay ningun Responsable Cargado! \n Cargue al menos uno, antes de cargar un viaje");
        selectOpcionResponsable();
    }
    do {
        $repite = false;
        echo ("\nIngrese ID del Viaje: ");
        $idviaje = trim(fgets(STDIN));
        echo ("\n");

        if ($objViaje->buscar($idviaje)) {
            echo ("ERROR-> este ID ya se encuentra cargado ingrese otro\n");
            $repite = true;
        }
    } while ($repite);


    //Verifico que no se repita el Destino, la Empresa y el Responsable en otro viaje
    do {
        echo ("\nIngrese el Destino: ");
        $destino = trim(fgets(STDIN));

        echo ("Eliga una de las siguientes empresas: ");
        $objEmpresa = elegirEmpresa();  //retorna la empresa elegida

        echo ("Ingrese uno de los siguientes Responsables: ");
        $objResponsable = elegirResponsable(); //retorna el responsable elegido


    } while (seRepiteViaje($destino, $objEmpresa, $objResponsable));


    echo ("Ingrese cantidad maxima de pasajeros: ");
    $cantMaxPasajeros = trim(fgets(STDIN));

    echo ("Ingrese el Importe: ");
    $importe = trim(fgets(STDIN));

    echo ("Ingrese Tipo de Asiento: (cama/semicama) ");
    $tipoAsiento = trim(fgets(STDIN));

    echo ("El viaje es ida y vuelta (si/no)");
    $idaYvuelta = trim(fgets(STDIN));

    $arrayPasajeros = array();

    $objViaje->cargar($idviaje, $destino, $objEmpresa, $cantMaxPasajeros, $objResponsable, $importe, $tipoAsiento, $idaYvuelta, $arrayPasajeros);

    // Inserto el OBj Viaje en la base de datos
    $respuesta =  $objViaje->insertar();

    if ($respuesta) {
        echo "\n /\/\/El Viaje fue ingresado Con Exito\/\/\' \n";
        /*     echo"id viaje: ".$objViaje->getCodigo(); */
    } else {
        echo $objViaje->getmensajeoperacion();
    }

    echo ("\nDesea Cargar Pasajeros ahora o mas tarde?\n");
    echo ("1-Ahora \n2-Más tarde\n");
    $opcion = trim(fgets(STDIN));
    if ($opcion == 1) {

        $arrayPasajeros = cargarPasajeros($cantMaxPasajeros, $objViaje);

        $objViaje->setColeccion_pasajeros($arrayPasajeros);
    } else {
        echo ("\nPuede cargar los pasajeros cuando desee en su menú\n");
    }
}


/**
 * Esta funcion verifica si no se repite un viaje con misma EMPRESA, mismo Destino, y mismo Responsable
 * @param string $destino1
 * @param Empresa $objEmpresa
 * @param ResponsableV $objResponsable
 * @return bool true en caso de que se repita
 */
function seRepiteViaje($destino1, $objEmpresa, $objResponsable)
{
    $arregloViajes = array();
    $objViaje = new Viaje();

    $arregloViajes = $objViaje->listar();

    $seRepite = false;
    $i = 0;

    while ($i < count($arregloViajes) && $seRepite == false) {

        $destino2 = $arregloViajes[$i]->getDestino();

        $empresa = $arregloViajes[$i]->getEmpresa();

        $responsable = $arregloViajes[$i]->getResponsableViaje();


        if ($destino1 == $destino2 && $empresa == $objEmpresa && $responsable == $objResponsable) {
            echo ("ERROR-> No se puede ingresar un viaje con DESTINO, EMPRESA Y RESPONSABLE iguales a otro viaje\n");
            $seRepite = true;
        }

        $i++;
    }
    return $seRepite;
}

/**
 * Esta funcion verifica si no se repite una Empresa con el mismo NOMBRE 
 * @param string $enombre
 * @return bool true en caso de que se repita
 */
function seRepiteEmpresa($enombre)
{
    $arregloEmpresa = array();
    $objEmpresa = new Empresa();

    $arregloEmpresa = $objEmpresa->listar();

    $seRepite = false;
    $i = 0;

    while ($i < count($arregloEmpresa) && $seRepite == false) {

        $nombre = $arregloEmpresa[$i]->getEnombre();

        if ($nombre == $enombre) {
            echo ("ERROR-> Ya existe una empresa con el mismo Nombre: por favor ingrese otro Nombre: \n \n");
            $seRepite = true;
        }

        $i++;
    }
    return $seRepite;
}



/**
 * Esta funcion carga una cantidad de pasajeros a la base de datos
 * @param int $cant cantidad maxima de pasajeros
 * @param Viaje $unviaje
 * @return array con los pasajeros
 */
function cargarPasajeros($cant, $unviaje)
{
    $i = 0;
    $seguir = true;
    $objPasajero = new Pasajero();
    $arrayPasajeros = $unviaje->getColeccion_pasajeros();

    echo"hay en el arreglo : ".count($arrayPasajeros);

    if (count($arrayPasajeros) >= $cant) {
        
        echo("ERROR-> No hay asientos disponibles---La cantidad maxima de pasajeros es: ".$cant." y hay cargados: ".count($arrayPasajeros)." pasajeros");
    }else{

        
    echo ("\nCarga de Pasajeros: \n");

    while ($i < $cant && $seguir) {

        //verifico que no esté cargado el mismo pasajero
        do {
            $repite = false;
            echo ("Ingrese el Nro Documento: ");
            $doc = trim(fgets(STDIN));
            echo ("\n");

            $encontro = $objPasajero->buscar($doc);

            if ($encontro) {
                echo ("ERROR-> este pasajero ya se encuentra cargado \n");
                $repite = true;
            }
        } while ($repite);

        echo ("Ingrese el Nombre: ");
        $nombre = trim(fgets(STDIN));
        echo ("\n");
        echo ("Ingrese el apellido: ");
        $apellido = trim(fgets(STDIN));
        echo ("\n");
        echo ("Ingrese el telefono: ");
        $telefono = trim(fgets(STDIN));
        echo ("\n");

        $objPasajero->cargar($doc, $nombre, $apellido, $telefono, $unviaje);

        // Inserto el OBj Pasajero en la base de datos
        $respuesta = $objPasajero->insertar();
        if ($respuesta == true) {
            echo "\n/\/\/El Pasajero fue ingresado Con Exito\/\/\ \n";
            array_push($arrayPasajeros, $objPasajero);

            print_r($arrayPasajeros);
            echo " ".count($arrayPasajeros);

            $unviaje->setColeccion_pasajeros($arrayPasajeros);

        } else {
            echo $objPasajero->getmensajeoperacion();
        }
        $i++;

        if ($i < $cant) {
            echo ("¿Desea agregar el proximo pasajero? \n 1-Si \n 2-No \n");
            $opcion = trim(fgets(STDIN));
            if ($opcion == 2) {
                $seguir = false;
            }
        }
    }

    }

    return $arrayPasajeros;
}


/**
 * Esta funcion verifica que hayan empresas cargadas
 * @return bol true en caso de que hayan empresas cargadas, false en caso contrario
 */
function verificarEmpresasCargadas()
{
    $result = true;
    $arregloEmpresas = array();
    $objEmpresa = new Empresa();

    $arregloEmpresas = $objEmpresa->listar();

    if ($arregloEmpresas == null) {
        $result = false;
    }

    return $result;
}

/**
 * Esta funcion verifica que hayan Responsables cargados
 * @return bol true en caso de que hayan Responsables cargados, false en caso contrario
 */
function verificarResponsablesCargados()
{
    $result = true;
    $arregloResponsables = array();
    $objResponsable = new ResponsableV();

    $arregloResponsables = $objResponsable->listar();

    if ($arregloResponsables == null) {
        $result = false;
    }

    return $result;
}


/**
 * Esta funcion le da al usuario la opcion de elegir que Responsable quiere
 * @return ResponsableV 
 */
function elegirResponsable()
{
    $arregloResponsable = array();
    $objResponsable = new ResponsableV();

    $arregloResponsable = $objResponsable->listar();
    echo (mostrar_arreglo($arregloResponsable));

    echo ("\n-- --- --- --- --- --\n");
    echo ("\nEscriba el NRO de Empleado: ");
    $nroEmpleado = trim(fgets(STDIN));
    echo ("\n");
    $esta = $objResponsable->buscar($nroEmpleado);

    while ($esta == false) {

        echo ("Este Responsable no existe, Elija uno existente: ");
        $nroEmpleado = trim(fgets(STDIN));
        echo ("\n");
        $esta = $objResponsable->buscar($nroEmpleado);
    }

    return $objResponsable;
}

/**
 * Esta funcion le da al usuario la opcion de elegir que empresa quiere
 * @return Empresa
 */
function elegirEmpresa()
{
    $arregloEmpresas = array();
    $objEmpresa = new Empresa();

    $arregloEmpresas = $objEmpresa->listar();
    echo (mostrar_arreglo($arregloEmpresas));

    echo ("\n-- --- --- --- --- --\n");
    echo ("\nEscriba el ID de la empresa: ");
    $idEmpresa = trim(fgets(STDIN));
    echo ("\n");

    $esta = $objEmpresa->buscar($idEmpresa);

    while ($esta == false) {

        echo ("Esta empresa no existe, Elija una existente: ");
        $idEmpresa = trim(fgets(STDIN));
        echo ("\n");
        $esta = $objEmpresa->buscar($idEmpresa);
    }

    return $objEmpresa;
}

/**
 * Está funcion hace un recorrido al arreglo para mostrar la informacion del arreglo
 * @return String
 */
function mostrar_arreglo($arreglo)
{

    $cadena = " ";
    for ($i = 0; $i < count($arreglo); $i++) {
        $objEmpresa = $arreglo[$i];
        $cadena = $cadena . "\n-- --- --- --- --- --\n";
        $cadena = $cadena . $objEmpresa;
    }
    return $cadena;
}

/**
 * Está funcion hace un recorrido al arreglo para mostrar la informacion del arreglo
 * @return String
 */
function mostrar_arreglo_responsable($arreglo)
{

    $cadena = " ";
    for ($i = 0; $i < count($arreglo); $i++) {
        $objResponsable = $arreglo[$i];
        $cadena = $cadena . "\n--- Responsable " . ($i + 1) . " ---: \n";
        $cadena = $cadena . $objResponsable;
    }
    return $cadena;
}

/**
 * Funcion para cargar una o varias empresas
 */
function cargarEmpresa()
{
    $objEmpresa = new Empresa();
    

   do{


    do {
        $repite = false;
        echo ("Ingrese el ID de la empresa: ");
        $idEmpresa = trim(fgets(STDIN));
        echo ("\n");

        if ($objEmpresa->buscar($idEmpresa)) {
            echo ("ERROR-> este ID ya se encuentra cargado ingrese otro\n");
            $repite = true;
        }
    } while ($repite);

    //verifico que no se repita el NOMBRE de la Empresa
    do {
        echo ("Ingrese el nombre de la empresa: ");
        $enombre = trim(fgets(STDIN));
        echo ("\n");

    } while (seRepiteEmpresa($enombre));

    echo ("Ingrese la dirección de la empresa: ");
    $edireccion = trim(fgets(STDIN));
    echo ("\n");

  
    $objEmpresa->cargar($idEmpresa,$enombre, $edireccion);

    // Inserto el OBj Empresa en la base de datos
    $respuesta = $objEmpresa->insertar();
    if ($respuesta == true) {
        echo "\nLa empresa fue ingresada Con Exito\n";
    } else {
        echo $objEmpresa->getmensajeoperacion();
    }



    echo ("¿Desa agregar otra empresa? \n 1-Si \n 2-No \n");
    $opcion = trim(fgets(STDIN));
    if ($opcion == 1) {
        $seguir = true;
    } else {
        $seguir = false;
    }

    }while($seguir);
}

//MENU DE OPCIONES
do {
    $opcion = seleccionarOpcion();

    switch ($opcion) {
        case '1':
            //submenu viajes
            selectOpcionViaje();
            break;
        case '2':
            //submenu empresas
            selectOpcionEmpresa();
            break;
        case '3':
            //submenu responsables
            selectOpcionResponsable();
            break;
        case '4':
            //submenu pasajeros
            selectOpcionPasajero();
            break;
        case '5':
            //Salir
            $opcion = 5;
            break;
    }
} while ($opcion != 5);


/** 
 * Esta funcion permite seleccionar una opcion del menu
 * @return int
 */
function seleccionarOpcion()
{
    //int $opcion
    $opcion = 0;
    echo " \n";
    echo "Elija una opcion valida: \n";
    echo " \n";
    while ($opcion != 5) {
        echo "Menú de opciones \n";
        /**Cargar una empresa */
        echo "1)Viajes\n"; //submenu viajes
        echo "2)Empresas\n"; //submenu empresas
        echo "3)Responsables\n"; //submenu responsables
        echo "4)Pasajeros \n"; //submenu pasajeros
        echo "5)Salir \n";

        $opcion = solicitarNumeroEntre(1, 5);
        if ($opcion != 5) {
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
function selectOpcionViaje()
{
    //int $opcion
    $opcion = 0;

    while ($opcion != 5) {
        echo " \n";
        echo "Menu VIAJE: \n";
        echo "1)Cargar un nuevo Viaje\n";
        echo "2)Modificar un Viaje\n";
        echo "3)Eliminar un Viaje\n";
        echo "4)Listar Viajes\n";
        echo "5)Volver \n";

        $opcion = solicitarNumeroEntre(1, 5);
        /*       if($opcion!= 5){
            break;
        }  */

        switch ($opcion) {
            case '1':
                //
                cargarViaje();

                break;
            case '2':
                //
                echo ("entré 2 ");
                break;
            case '3':
                //
                echo ("entré 3");
                break;
            case '4':
                //
                echo ("entré 4");
                break;
            case '5':
                //volver
                $opcion = 5;
                break;
        }
    }
}

/** 
 * Esta funcion permite seleccionar una opcion del submenu Responsables
 * @return int
 */
function selectOpcionResponsable()
{
    //int $opcion
    $opcion = 0;

    while ($opcion != 5) {


        while ($opcion != 5) {
            echo " \n";
            echo "Menu RESPONSABLES: \n";
            echo "1)Cargar un nuevo Responsable\n";
            echo "2)Modificar un Responsable\n";
            echo "3)Eliminar un Responsable\n";
            echo "4)Listar Responsables\n";
            echo "5)Volver \n";

            $opcion = solicitarNumeroEntre(1, 5);
            /*       if($opcion!= 5){
                break;
            }  */

            switch ($opcion) {
                case '1':
                    //
                    echo ("entré 1 ");
                    break;
                case '2':
                    //
                    echo ("entré 2 ");
                    break;
                case '3':
                    //
                    echo ("entré 3");
                    break;
                case '4':
                    //
                    echo ("entré 4");
                    break;
                case '5':
                    //volver
                    $opcion = 5;
                    break;
            }
        }
    }
}

/** 
 * Esta funcion permite seleccionar una opcion del submenu Pasajeros
 * @return int
 */
function selectOpcionPasajero()
{
    //int $opcion
    $opcion = 0;

    while ($opcion != 5) {
        echo " \n";
        echo "Menu PASAJEROS: \n";
        echo "1)Cargar un nuevo Pasajero\n";
        echo "2)Modificar un Pasajero\n";
        echo "3)Eliminar un Pasajero\n";
        echo "4)Listar Pasajeros\n";
        echo "5)Volver \n";

        $opcion = solicitarNumeroEntre(1, 5);
        /*       if($opcion!= 5){
              break;
          }  */

        switch ($opcion) {
            case '1': //Cargar Pasajeros

                //verificar de que existan viajes

                //Corroborar de que exista el idviaje dado por el usuario

                //obtener la cantidadMaxima de pasajeros del objeto Viaje anterior

                $viajeprueba = new Viaje();

                $viajeprueba->buscar(4);

                $arregloDepasajeros = $viajeprueba->getColeccion_pasajeros();

                print_r($arregloDepasajeros);

                $arreglo= cargarPasajeros(1,$viajeprueba); 

                print_r($arreglo);

                break;
            case '2':
                //
                echo ("entré 2 ");
                break;
            case '3':
                //
                echo ("entré 3");
                break;
            case '4':
                //
                echo ("entré 4");
                break;
            case '5':
                //volver
                $opcion = 5;
                break;
        }
    }
}

/** 
 * Esta funcion permite seleccionar una opcion del submenu Empresas
 * @return int
 */
function selectOpcionEmpresa()
{
    //int $opcion
    $opcion = 0;

    while ($opcion != 5) {
        echo " \n";
        echo "Menu EMPRESAS: \n";
        echo "1)Cargar una nueva Empresa\n";
        echo "2)Modificar una Empresa\n";
        echo "3)Eliminar una Empresa\n";
        echo "4)Listar Empresas\n";
        echo "5)Volver \n";

        $opcion = solicitarNumeroEntre(1, 5);
        /*       if($opcion!= 5){
              break;
          }  */

        switch ($opcion) {
            case '1':
                //
                echo ("entré 1 ");
                cargarEmpresa();

                break;
            case '2':
                //
                echo ("entré 2 ");
                break;
            case '3':
                //
                echo ("entré 3");
                break;
            case '4':
                //
                echo ("entré 4");
                break;
            case '5':
                //volver
                $opcion = 5;
                break;
        }
    }
}
