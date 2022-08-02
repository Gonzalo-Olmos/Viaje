<?php
/* include_once("Viaje.php"); */
include_once("Pasajero.php");
include_once("ResponsableV.php");
include_once("Empresa.php");


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
        echo ("\n!No hay ninguna Empresa Cargada! \n Cargue al menos una, antes de cargar un viaje");
        cargarEmpresa();
    }
    if (verificarResponsablesCargados() == false) {

        echo ("\n!No hay ningun Responsable Cargado! \n Cargue al menos uno, antes de cargar un viaje\n");
        cargarResponsable();
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



     $objViaje->cargar($idviaje, $destino, $objEmpresa, $cantMaxPasajeros, $objResponsable, $importe, $tipoAsiento, $idaYvuelta); 

 
    // Inserto el OBj Viaje en la base de datos
    $respuesta =  $objViaje->insertar();

    if ($respuesta) {
        echo "\n /\/\/El Viaje fue ingresado Con Exito\/\/\' \n";
            
    } else {
        echo $objViaje->getmensajeoperacion();
    }

    echo ("\nDesea Cargar Pasajeros ahora o mas tarde?\n");
    echo ("1-Ahora \n2-Más tarde\n");
    $opcion = trim(fgets(STDIN));
    if ($opcion == 1) {



        $objViaje->cargarPasajeros($cantMaxPasajeros);
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

    $arregloViajes = $objViaje->listar("");

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
 * Esta funcion verifica si no se repite un Responsable con la misma licencia 
 * @param string $nroLicencia
 * @return bool true en caso de que se repita
 */
function seRepiteResponsable($nroLicencia)
{
    $arregloResponsable = array();
    $objResponsable = new ResponsableV();

    $arregloResponsable = $objResponsable->listar();

    $seRepite = false;
    $i = 0;

    while ($i < count($arregloResponsable) && $seRepite == false) {

        $licencia = $arregloResponsable[$i]->getNroLicencia();

        if ($licencia == $nroLicencia) {
            echo ("ERROR-> Ya existe un Responsable con la mimsa Licencia: por favor ingrese otro Numero: \n \n");
            $seRepite = true;
        }

        $i++;
    }
    return $seRepite;
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
 * Esta funcion verifica que hayan Viajes cargados
 * @return bol true en caso de que hayan Viajes cargados, false en caso contrario
 */
function verificarViajesCargados()
{
    $result = true;
    $arregloViajes = array();
    $objViaje = new Viaje();

    $arregloViajes = $objViaje->listar("");

    if ($arregloViajes == null) {
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
        $obj= $arreglo[$i];
        $cadena = $cadena . "\n --->+<------------>+<---\n";
        $cadena = $cadena . $obj;
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


    do {


    /*     do {
            $repite = false;
            echo ("Ingrese el ID de la empresa: ");
            $idEmpresa = trim(fgets(STDIN));
            echo ("\n");

            if ($objEmpresa->buscar($idEmpresa)) {
                echo ("ERROR-> este ID ya se encuentra cargado ingrese otro\n");
                $repite = true;
            }
        } while ($repite); */

        //verifico que no se repita el NOMBRE de la Empresa
        do {
            echo ("Ingrese el nombre de la empresa: ");
            $enombre = trim(fgets(STDIN));
            echo ("\n");
        } while (seRepiteEmpresa($enombre));

        echo ("Ingrese la dirección de la empresa: ");
        $edireccion = trim(fgets(STDIN));
        echo ("\n");


       /*  $objEmpresa->cargar($idEmpresa, $enombre, $edireccion); */
        $objEmpresa->setEnombre($enombre);
        $objEmpresa->setEdireccion($edireccion);


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
    } while ($seguir);
}

/**
 * Funcion para cargar uno o varios Responsables
 */
function cargarResponsable()
{
    $objResponsable = new ResponsableV();
    do {

        /*  do {
            $repite = false;
            echo ("Ingrese el nro del Responsable: ");
            $nroEmpleado = trim(fgets(STDIN));
            echo ("\n");
    
            if ($objResponsable->buscar($nroEmpleado)) {
                echo ("ERROR-> este nro de responsable ya se encuentra cargado ingrese otro\n");
                $repite = true;
            }
        } while ($repite);  */

        //verifico que no se repita el nro de licencia del Responsable
        do {
            echo ("Ingrese el Nro de Licencia: ");
            $nroLicencia = trim(fgets(STDIN));
            echo ("\n");
        } while (seRepiteResponsable($nroLicencia));

        echo ("Ingrese el nombre del Responsable: ");
        $nombreR = trim(fgets(STDIN));
        echo ("\n");

        echo ("Ingrese el Apellido del Responsable: ");
        $apellidoR = trim(fgets(STDIN));
        echo ("\n");

       /*  $objResponsable->cargar(0, $nroLicencia, $nombreR, $apellidoR); */
        $objResponsable->setNroLicencia( $nroLicencia);
        $objResponsable->setNombre( $nombreR);
        $objResponsable->setApellido( $apellidoR);

        // Inserto el Obj Responsable en la base de datos
        $respuesta = $objResponsable->insertar();
        if ($respuesta == true) {
            echo "\n/\/\/El Responsable fue ingresado Con Exito\/\/\/\n";
        } else {
            echo $objResponsable->getmensajeoperacion();
        }



        echo ("¿Desa agregar otro Responsable? \n 1-Si \n 2-No \n");
        $opcion = trim(fgets(STDIN));
        if ($opcion == 1) {
            $seguir = true;
        } else {
            $seguir = false;
        }
    } while ($seguir);
}


/**
 * Esta funcion elimina un registro, dado una clave primaria y un objeto de X tipo. El objeto es para buscar el registro
 * @param int $key
 * @param Obj cualquier tipo
 * @return bool true si se pudo eliminar, false en caso de que no se haya encontrado el registro
 */
function eliminarRegistro($key, $obj)
{

    $pudoEliminar = true;
    $encontroObj = $obj->buscar($key);

    if ($encontroObj) {

        $obj->eliminar();
    } else {
        $pudoEliminar = false;
    }
    return $pudoEliminar;
}

function modificarViaje()
{
    $objViaje = new Viaje();

    echo ("Ingrese el ID del Viaje que desea Modificar:\n ");
    $idviaje = trim(fgets(STDIN));

    if ($objViaje->buscar($idviaje)) {

        echo ("Seleccione el Atributo que desea Modificar:\n ");
        echo "1-Destino \n 2-Cantidad Max Pasajeros \n 3-Id empresa \n 4-Nro Empleado\n 5-Importe \n 6-Tipo Asiento \n 7-Ida y vuelta\n  ";
        $opcion = trim(fgets(STDIN));
        switch ($opcion) {
            case '1':
                echo ("Ingrese el nuevo Destino:\n ");
                $nuevoDato = trim(fgets(STDIN));
                $objViaje->setDestino($nuevoDato);

                $respuesta = $objViaje->modificar();

                if ($respuesta == true) {

                    echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                } else {
                    echo $objViaje->getmensajeoperacion();
                }

                break;

            case '2':
                echo ("Ingrese la nueva cantidad: (Mayor a '" . $objViaje->getCantMaxPasajeros() . "' )\n  ");
                $nuevoDato = trim(fgets(STDIN));

                $objViaje->setCantMaxPasajeros($nuevoDato);

                $respuesta = $objViaje->modificar();

                if ($respuesta == true) {

                    echo " \n -.-.Los datos fueron actualizados correctamente.-.-\n ";
                } else {
                    echo $objViaje->getmensajeoperacion();
                }

                break;

            case '3':
                $objEmpresa = new Empresa();
                echo ("Ingrese el nuevo Id de Empresa:\n ");
                $nuevoIdEmpresa = trim(fgets(STDIN));

                if ($objEmpresa->buscar($nuevoIdEmpresa)) {

                    $objViaje->setEmpresa($objEmpresa);

                    $respuesta = $objViaje->modificar();

                    if ($respuesta == true) {

                        echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                    } else {
                        echo $objViaje->getmensajeoperacion();
                    }
                } else {
                    echo "\n Esta Empresa no existe \n";
                }

                break;
            case '4':
                $objResponsable = new ResponsableV();
                echo ("Ingrese el nuevo Nro de Responsable:\n ");
                $nuevoNroResponsable = trim(fgets(STDIN));

                if ($objResponsable->buscar($nuevoNroResponsable)) {

                    $objViaje->setResponsableViaje($objResponsable);

                    $respuesta = $objViaje->modificar();

                    if ($respuesta == true) {

                        echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                    } else {
                        echo $objViaje->getmensajeoperacion();
                    }
                } else {
                    echo "\n Este Responsable no existe \n";
                }

                break;
            case '5':
                echo ("Ingrese el nuevo Importe:\n ");
                $nuevoDato = trim(fgets(STDIN));
                $objViaje->setImporte($nuevoDato);

                $respuesta = $objViaje->modificar();

                if ($respuesta == true) {

                    echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                } else {
                    echo $objViaje->getmensajeoperacion();
                }
                break;

            case '6':
                echo ("Ingrese el nuevo Dato (cama/semicama):\n ");
                $nuevoDato = trim(fgets(STDIN));
                $objViaje->setTipoAsiento($nuevoDato);

                $respuesta = $objViaje->modificar();

                if ($respuesta == true) {

                    echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                } else {
                    echo $objViaje->getmensajeoperacion();
                }
                break;

            case '7':
                echo ("Ingrese el nuevo Dato Ida Y vuelta (si/no):\n ");
                $nuevoDato = trim(fgets(STDIN));
                $objViaje->setIdaYvuelta($nuevoDato);

                $respuesta = $objViaje->modificar();

                if ($respuesta == true) {

                    echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                } else {
                    echo $objViaje->getmensajeoperacion();
                }
                break;

            default:
                echo "\n ///Opcion Invalida///\n ";
                break;
        }
    } else {
        echo "\n Este viaje No Existe\n ";
    }
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
                //MODIFICAR VIAJE
                modificarViaje();
                break;

            case '3':
                //Eliminar Viaje
                $objPasajero = new Pasajero();
                $objViaje = new Viaje();
                echo ("\nIngrese El ID del viaje que desea Eliminar: ");
                $idviajeEliminar = trim(fgets(STDIN));


                if ($objViaje->buscar($idviajeEliminar)) {
                    //verificar de que no hayan Pasajeros en el Viaje para poder eliminar
                    $arregloPasajerosAsociados = $objPasajero->listarReferenciasPorID($idviajeEliminar);

                    if ($arregloPasajerosAsociados == null) {
                        //procedo a la eliminacion
                        if (eliminarRegistro($idviajeEliminar, $objViaje)) {
                            echo ("\n -Viaje Eliminado Con Exito- \n");
                        } else {
                            echo ("\n -No se pudo eliminar el viaje- \n");
                        }
                    } else {
                        echo ("\n-El viaje Contiene Pasajeros, si continua se eliminaran Los Pasajeros Asociados \n ¿Desea Continuar de todas formas? (si/no)\n");
                        $opcion =  trim(fgets(STDIN));

                        if ($opcion == "si") {

                            for ($i = 0; $i < count($arregloPasajerosAsociados); $i++) {

                                $arregloPasajerosAsociados[$i]->eliminar();
                            }

                            $objViaje->eliminar();
                            echo ("\n -Viaje Eliminado Con Exito- \n");
                        }
                    }
                } else {
                    echo ("\n -No Existe el Viaje que desea eliminar-\n ");
                }

                break;
            case '4':
                //Listar Viajes
                    listarViajes();
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
                    //Cargar Responsable

                    cargarResponsable();

                    break;
                case '2':
                    // MODIOFICAR RESPONSABLE
                    modificarResponsable();
                   
                    break;
                case '3':
                    //ELIMINAR Responsable
                    $objResponsable = new ResponsableV();
                    $objViaje = new Viaje();
                    $objPasajero = new Pasajero();
                    $arrayPasajeros = new Pasajero();

                    echo ("Ingrese el nro Empleado del Responsable que desea Eliminar: ");
                    $idResponsableEliminar = trim(fgets(STDIN));
                    $condicionConsulta = "rnumeroempleado = " . $idResponsableEliminar;


                    if ($objResponsable->buscar($idResponsableEliminar)) {
                        //verificar de que la empresa no esté relacionada con algún viaje
                        $arregloViajesAsociados = $objViaje->listar($condicionConsulta);

                        if ($arregloViajesAsociados == null) {
                            //procedo a la eliminacion
                            if ($objResponsable->eliminar()) {
                                echo ("\n -Responsable Eliminado Con Exito- \n");
                            } else {
                                echo ("\n -No se pudo eliminar el Responsable- \n");
                            }
                        } else {
                            echo ("\n-El responsable está asociado a un Viaje- \n");
                            echo ("Se borraran todos los viajes asociados, incluyendo pasajeros\n ¿Eliminar de Todos Modos? (si/no):\n");
                            $opcion =  trim(fgets(STDIN));

                            if ($opcion == "si") {
                                //entro a una repetitiva y por cada registro de $arregloRegistrosViajes obtengo su IDviaje
                                for ($i = 0; $i < count($arregloViajesAsociados); $i++) {

                                    $idviaje = $arregloViajesAsociados[$i]->getCodigo();

                                    //listo todos los pasajeros en un array. y eliminos todos los pasajeros con ese IDviaje
                                    $arrayPasajeros = $objPasajero->listarReferenciasPorID($idviaje);
                                    if (count($arrayPasajeros) > 0) {
                                        //borro cada registro del array
                                        for ($j = 0; $j < count($arrayPasajeros); $j++) {

                                            $arrayPasajeros[$j]->eliminar();
                                        }
                                        //ahora puedo elimnar el viaje
                                        $arregloViajesAsociados[$i]->eliminar();
                                    } else {
                                        $arregloViajesAsociados[$i]->eliminar();
                                    }
                                }
                                $objResponsable->eliminar();
                                echo ("\n -Responsable Eliminado Con Exito- \n");
                            }
                        }
                    } else {
                        echo ("\n -No Existe el Responsable que desea eliminar-\n ");
                    }

                    break;
                case '4':
                    //LISTAR
                    listarResponsables();
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
    $viaje = new Viaje();
    $pasajero = new Pasajero();

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
                if (verificarViajesCargados() == false) {
                    echo ("!No hay ningun Viaje Cargado! \n Cargue al menos uno, antes de cargar un Pasajero");
                    break;
                }

                //Corroborar de que exista el idviaje dado por el usuario
                do {
                    $repetir = false;
                    echo ("\n Ingrese el ID de viaje que quiere asignar al pasajero: ");
                    $idviaje = trim(fgets(STDIN));

                    $encontro = $viaje->buscar($idviaje);

                    if ($encontro == false) {
                        echo ("\nERROR-> Este Viaje no existe en La Base de Datos\n ");
                        $repetir = true;
                    } else {

                        //obtener la cantidadMaxima de pasajeros del objeto Viaje anterior
                        $cantMaxPasajeros = $viaje->getCantMaxPasajeros();

                        /*echo"cant max pasajeros  ".$cantMaxPasajeros; */
                        $viaje->cargarPasajeros($cantMaxPasajeros);

                        /*  $arregloPasajerosPorID = $pasajero->listarReferenciasPorID($idviaje);
                        $cantPasajerosPorId = count($arregloPasajerosPorID); */
                    }
                } while ($repetir);

                break;
            case '2':
                //MODIFICAR PASAJERO
                $objPasajero = new Pasajero();

                echo ("Ingrese el DNI del pasajero que desea Modificar:\n ");
                $dniPasajero = trim(fgets(STDIN));

                if ($objPasajero->buscar($dniPasajero)) {

                    echo ("Seleccione el Atributo que desea Modificar:\n ");
                    echo "1-Nombre \n 2-Apellido \n 3-telefono \n 4-Viaje\n ";
                    $opcion = trim(fgets(STDIN));
                    switch ($opcion) {
                        case '1':
                            echo ("Ingrese el nuevo Dato:\n ");
                            $nuevoDato = trim(fgets(STDIN));
                            $objPasajero->setNombre($nuevoDato);

                            $respuesta = $objPasajero->modificar();

                            if ($respuesta == true) {

                                echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                            } else {
                                echo $objPasajero->getmensajeoperacion();
                            }

                            break;

                        case '2':
                            echo ("Ingrese el nuevo Dato:\n ");
                            $nuevoDato = trim(fgets(STDIN));
                            $objPasajero->setApellido($nuevoDato);

                            $respuesta = $objPasajero->modificar();

                            if ($respuesta == true) {

                                echo " \n -.-.Los datos fueron actualizados correctamente.-.-\n ";
                            } else {
                                echo $objPasajero->getmensajeoperacion();
                            }

                            break;

                        case '3':
                            echo ("Ingrese el nuevo Dato:\n ");
                            $nuevoDato = trim(fgets(STDIN));
                            $objPasajero->setTelefono($nuevoDato);

                            $respuesta = $objPasajero->modificar();

                            if ($respuesta == true) {

                                echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                            } else {
                                echo $objPasajero->getmensajeoperacion();
                            }
                            break;
                        case '4':
                            echo ("Ingrese el nuevo ID viaje:\n ");
                            $objViaje = new Viaje();
                            $nuevoIdViaje = trim(fgets(STDIN));

                            if ($objViaje->buscar($nuevoIdViaje)) {

                                $cantMaxPasajeros = $objViaje->getCantMaxPasajeros();
                                $arrayPasajerosPorId = $objPasajero->listarReferenciasPorID($nuevoIdViaje);

                                if (count($arrayPasajerosPorId) < $cantMaxPasajeros) {

                                    $objPasajero->setViaje($objViaje);

                                    $respuesta = $objPasajero->modificar();

                                    if ($respuesta == true) {

                                        echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                                    } else {
                                        echo $objPasajero->getmensajeoperacion();
                                    }
                                } else {
                                    echo "\n El Maximo de Pasajeros está completo para dicho Viaje\n ";
                                }
                            } else {
                                echo " \nEl Viaje Ingresado no existe \n";
                            }

                            break;

                        default:
                            echo "\n ///Opcion Invalida///\n ";
                            break;
                    }
                } else {
                    echo ("\nEste pasajero no Existe\n ");
                }


                break;
            case '3':
                //ELIMINAR PASAJERO
                $objPasajero = new Pasajero();
                echo ("Ingrese el nro Documento del pasajero a Eliminar: ");
                $dni = trim(fgets(STDIN));

                if (eliminarRegistro($dni, $objPasajero)) {
                    echo ("\n -Pasajero Eliminado Con Exito- \n");
                } else {
                    echo ("\n -Este Pasajero no Existe- \n");
                }

                break;
            case '4':
                //LISTAR
                listarPasajeros();
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
                //CARGAR EMPRESA

                cargarEmpresa();

                break;
            case '2':
                //MODIFICAR EMPRESA
                modificarEmpresa();

                break;
            case '3':
                //ELIMINAR EMPRESA
                $objEmpresa = new Empresa();
                $objViaje = new Viaje();
                $objPasajero = new Pasajero();
                $arrayPasajeros = new Pasajero();

                echo ("Ingrese el ID de la empresa que desea Eliminar: ");
                $idEmpresaEliminar = trim(fgets(STDIN));
                $condicionConsulta = "idempresa = " . $idEmpresaEliminar;


                if ($objEmpresa->buscar($idEmpresaEliminar)) {
                    //verificar de que la empresa no esté relacionada con algún viaje
                    $arregloViajesAsociados = $objViaje->listar($condicionConsulta);

                    if ($arregloViajesAsociados == null) {
                        //procedo a la eliminacion
                        if (eliminarRegistro($idEmpresaEliminar, $objEmpresa)) {
                            echo ("\n -Empresa Eliminada Con Exito- \n");
                        } else {
                            echo ("\n -No se pudo eliminar la Empresa- \n");
                        }
                    } else {
                        echo ("\n-La Empresa está asociada a un Viaje- \n");
                        echo ("Se borraran todos los viajes asociados, incluyendo pasajeros\n ¿Eliminar de Todos Modos? (si/no):\n");
                        $opcion =  trim(fgets(STDIN));


                        if ($opcion == "si") {

                            //entro a una repetitiva y por cada registro de $arregloRegistrosViajes obtengo su IDviaje
                            for ($i = 0; $i < count($arregloViajesAsociados); $i++) {

                                $idviaje = $arregloViajesAsociados[$i]->getCodigo();

                                //listo todos los pasajeros en un array. y eliminos todos los pasajeros con ese IDviaje
                                $arrayPasajeros = $objPasajero->listarReferenciasPorID($idviaje);
                                if (count($arrayPasajeros) > 0) {
                                    //borro cada registro del array
                                    for ($j = 0; $j < count($arrayPasajeros); $j++) {

                                        $arrayPasajeros[$j]->eliminar();
                                    }
                                    //ahora puedo elimnar el viaje
                                    $arregloViajesAsociados[$i]->eliminar();
                                } else {
                                    $arregloViajesAsociados[$i]->eliminar();
                                }
                            }
                            $objEmpresa->eliminar();
                            echo ("\n -Empresa Eliminada Con Exito- \n");
                        }
                    }
                } else {
                    echo ("\n -No Existe la Empresa que desea eliminar-\n ");
                }

                break;
            case '4':
                //LISTAR EMPRESAS
                listarEmpresas();
                break;
            case '5':
                //volver
                $opcion = 5;
                break;
        }
    }
}


function modificarEmpresa(){

    $objEmpresa = new Empresa();
    $objViaje = new Viaje();
    $objPasajero = new Pasajero();


    //antes de actualizar la empresa debo actualizar el objEmpresa del/los viajes en los que se encuentra
    echo ("Ingrese el ID de la empresa que desea Modificar: ");
    $idEmpresa = trim(fgets(STDIN));
    $condicionConsulta = "idempresa = " . $idEmpresa;

    if ($objEmpresa->buscar($idEmpresa)) {


        echo ("Seleccione el Atributo que desea Modificar:\n ");
        echo "1-Nombre \n 2-Direccion\n";
        $opcion = trim(fgets(STDIN));

        switch ($opcion) {
            
            //Comienzo CASO 1
            case '1': 

                //verifico que no se repita el NOMBRE de la Empresa
                do {
                    echo ("Ingrese el nuevo Nombre: ");
                    $nuevonombre = trim(fgets(STDIN));
                    echo ("\n");
                } while (seRepiteEmpresa($nuevonombre));

                $objEmpresa->setEnombre($nuevonombre);


                //verificar de que la empresa no esté relacionada con algún viaje
                $arregloViajesAsociados = $objViaje->listar($condicionConsulta);

        
                if ($arregloViajesAsociados == null) {
                    //procedo a la Actualizacion
                    
                    $respuesta = $objEmpresa->modificar();

                    if ($respuesta == true) {

                        echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                    } else {
                        echo $objEmpresa->getmensajeoperacion();
                    }
                } else {
                    echo ("\n-La Empresa está asociada a un Viaje- \n");
                    echo ("Se actualizara La Empresa de los viajes asociados, incluyendo la de los pasajeros\n Actualizar de Todos Modos? (si/no):\n");
                    $opcion =  trim(fgets(STDIN));

                    if ($opcion == "si") {
                        //seteo el nuevo nombre al objeto
                        $objEmpresa->setEnombre($nuevonombre);
                        //entro a una repetitiva y por cada registro de $arregloRegistrosViajes obtengo su IDviaje y actualizo el obj empresa
                        for ($i = 0; $i < count($arregloViajesAsociados); $i++) {

                            $idviaje = $arregloViajesAsociados[$i]->getCodigo();

                            //listo todos los pasajeros en un array. y actualizo todos los pasajeros con ese IDviaje
                            $arrayPasajeros = $objPasajero->listarReferenciasPorID($idviaje);
                            if (count($arrayPasajeros) > 0) {
                                //actualizo cada registro del array
                                for ($j = 0; $j < count($arrayPasajeros); $j++) {

                                    $viaje = $arrayPasajeros[$j]->getViaje();
                                    $viaje->setEmpresa($objEmpresa);

                                    $arrayPasajeros[$j]->setViaje($viaje);

                        
                                    $arrayPasajeros[$j]->modificar();

                                   
                                }
                                //ahora puedo actualizar el viaje
                                $arregloViajesAsociados[$i]->setEmpresa($objEmpresa);
                              
                            } else {
                                $arregloViajesAsociados[$i]->setEmpresa($objEmpresa);
                                $arregloViajesAsociados[$i]->modificar();
                            }
                        }
                        
                        $respuesta = $objEmpresa->modificar();

                        if ($respuesta == true) {

                            echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                        } else {
                            echo $objEmpresa->getmensajeoperacion();
                        }
                    }
                }


                break;
                //FIN CASO 1

            case '2':
                echo ("Ingrese la nueva Direccion: ");
                $nuevaDireccion = trim(fgets(STDIN));
                $objEmpresa->setEdireccion($nuevaDireccion);

                $respuesta = $objEmpresa->modificar();

                if ($respuesta == true) {

                    echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
                } else {
                    echo $objEmpresa->getmensajeoperacion();
                }


                break;
            default:
                echo "\n Opcion Invalida \n";
                break;
        }
    } else {
        echo ("\n -No Existe la Empresa que desea Actualizar-\n ");
    }


}




function modificarResponsable(){

    $objResponsable= new ResponsableV();

    echo ("Ingrese el Nro de Empleado que desea Modificar: ");
    $nroEmpleado = trim(fgets(STDIN));

    if ($objResponsable->buscar($nroEmpleado )) {
       
    
    echo ("Seleccione el Atributo que desea Modificar:\n ");
    echo "1-nro Licencia \n 2-Apellido \n 3-Nombre \n ";
    $opcion = trim(fgets(STDIN));


    switch ($opcion) {
        case '1':
            echo ("Ingrese el nuevo Dato:\n ");
            $nuevoDato = trim(fgets(STDIN));
            $objResponsable->setNroLicencia($nuevoDato);

            $respuesta = $objResponsable->modificar();

            if ($respuesta == true) {

                echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
            } else {
                echo $objResponsable->getmensajeoperacion();
            }

            break;

        case '2':
            echo ("Ingrese el nuevo Dato:\n ");
            $nuevoDato = trim(fgets(STDIN));
            $objResponsable->setApellido($nuevoDato);

            $respuesta = $objResponsable->modificar();

            if ($respuesta == true) {

                echo " \n -.-.Los datos fueron actualizados correctamente.-.-\n ";
            } else {
                echo $objResponsable->getmensajeoperacion();
            }

            break;

        case '3':
            echo ("Ingrese el nuevo Dato:\n ");
            $nuevoDato = trim(fgets(STDIN));
            $objResponsable->setNombre($nuevoDato);

            $respuesta = $objResponsable->modificar();

            if ($respuesta == true) {

                echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
            } else {
                echo $objResponsable->getmensajeoperacion();
            }
            break;

        default:
            echo "\n ///Opcion Invalida///\n ";
            break;
    }


    }else {
    echo"Este Responsable No existe";
    }

}


function listarViajes(){

    $objViaje =new Viaje();

    $arrayViajes = $objViaje->listar("");

    $viajes = mostrar_arreglo($arrayViajes);

    echo $viajes;
}


function listarPasajeros(){

    $objPasajero =new Pasajero();

    $arrayPasajeros= $objPasajero->listar();

    if ($arrayPasajeros= $objPasajero->listar()) {
        # code...

    }else{

    }


   echo" ".implode($arrayPasajeros);

  /*   $pasajeros = mostrar_arreglo($arrayPasajeros); 
 
    echo $pasajeros;  */
}

function listarEmpresas(){

    $objEmpresa =new Empresa();

    $arrayEmpresas = $objEmpresa->listar();

    $emrpesas = mostrar_arreglo($arrayEmpresas);

    echo $emrpesas;
}


function listarResponsables(){
    $objResponsable =new ResponsableV();

    $arrayResponsable = $objResponsable->listar();

    $responsables = mostrar_arreglo($arrayResponsable);

    echo $responsables;


}




/* 
function actualizarEmpresaEnCascada()
{

    //verificar de que la empresa no esté relacionada con algún viaje
    $arregloViajesAsociados = $objViaje->listar($condicionConsulta);

    if ($arregloViajesAsociados == null) {
        //procedo a la Actualizacion

        $objEmpresa->setEnombre($nuevonombre);

        $respuesta = $objEmpresa->modificar();

        if ($respuesta == true) {

            echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
        } else {
            echo $objEmpresa->getmensajeoperacion();
        }
    } else {
        echo ("\n-La Empresa está asociada a un Viaje- \n");
        echo ("Se actualizara La Empresa de los viajes asociados, incluyendo la de los pasajeros\n Actualizar de Todos Modos? (si/no):\n");
        $opcion =  trim(fgets(STDIN));

        if ($opcion == "si") {
            //seteo el nuevo nombre al objeto
            $objEmpresa->setEnombre($nuevonombre);
            //entro a una repetitiva y por cada registro de $arregloRegistrosViajes obtengo su IDviaje y actualizo el obj empresa
            for ($i = 0; $i < count($arregloViajesAsociados); $i++) {

                $idviaje = $arregloViajesAsociados[$i]->getCodigo();

                //listo todos los pasajeros en un array. y actualizo todos los pasajeros con ese IDviaje
                $arrayPasajeros = $objPasajero->listarReferenciasPorID($idviaje);
                if (count($arrayPasajeros) > 0) {
                    //actualizo cada registro del array
                    for ($j = 0; $j < count($arrayPasajeros); $j++) {

                        $viaje = $arrayPasajeros[$j]->getViaje();
                        $viaje->setEmpresa($objEmpresa);

                        $arrayPasajeros[$j]->setViaje($viaje);

                        $arrayPasajeros[$j]->modificar();
                    }
                    //ahora puedo actualizar el viaje
                    $arregloViajesAsociados[$i]->setEmpresa($objEmpresa);
                    $arregloViajesAsociados[$i]->modificar();
                } else {
                    $arregloViajesAsociados[$i]->setEmpresa($objEmpresa);
                    $arregloViajesAsociados[$i]->modificar();
                }
            }

            $respuesta = $objEmpresa->modificar();

            if ($respuesta == true) {

                echo " \n -.-.Los datos fueron actualizados correctamente.-.-";
            } else {
                echo $objEmpresa->getmensajeoperacion();
            }
        }
    }
}
 */