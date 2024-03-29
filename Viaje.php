<?php
include_once("./BaseDeDatos/BaseDatos.php");

class Viaje
{

    //atributos de la clase
    private $codigo;
    private $destino;
    private $objEmpresa;
    private $cantMaxPasajeros;
    private $coleccion_pasajeros = [];
    private $objResponsableViaje; 
    private $importe;
    private $tipoAsiento; /*primera clase o no, semicama o cama*/
    private $idaYvuelta; // si o no
    private $mensajeoperacion;

    //Constructor
    public function __construct()
    {
        $this->codigo = "";
        $this->destino = "";
        $this->objEmpresa = new Empresa();
        $this->cantMaxPasajeros  = "";
        $this->objResponsableViaje = new ResponsableV();
        $this->importe  = "";
        $this->tipoAsiento  = "";
        $this->idaYvuelta = "";
        $this->coleccion_pasajeros = array();
    }

    //Funcion Cargar
    public function cargar($idviaje, $destino, $objEmpresa, $cantMaxPasajeros,  $objResponsableViaje, $importe, $tipoAsiento, $idaYvuelta){
        
        $this->setCodigo($idviaje);
        $this->setDestino($destino);
        $this->setEmpresa($objEmpresa);
        $this->setCantMaxPasajeros($cantMaxPasajeros);
        $this->setResponsableViaje($objResponsableViaje);
        $this->setImporte($importe);
        $this->setTipoAsiento($tipoAsiento);
        $this->setIdaYvuelta($idaYvuelta); 
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

    public function getEmpresa()
    {
        return $this->objEmpresa;
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

    public function getTipoAsiento() 
    {
        return $this->tipoAsiento;
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

    public function setEmpresa($objEmpresa)
    {
        $this->objEmpresa = $objEmpresa;
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
        $this->objResponsableViaje = $responsableViaje;
    }

    public function setTipoAsiento($tipoAsiento)
    {
        $this->tipoAsiento = $tipoAsiento;
    }

    public function setIdaYvuelta($idaYvuelta)
    {
        $this->idaYvuelta = $idaYvuelta;
    }
    public function setImporte($importe)
    {
        $this->importe = $importe;
    }

    public function getmensajeoperacion(){
		return $this->mensajeoperacion ;
	}
	public function setmensajeoperacion($mensajeoperacion){
		$this->mensajeoperacion=$mensajeoperacion;
	}


    
/**
 * Esta funcion carga una cantidad de pasajeros a la base de datos
 * @param int $cant cantidad maxima de pasajeros
 * @param Viaje $unviaje
 * 
 */
public function cargarPasajeros($cant)
{
    $i = 0;
    $seguir = true;
    $objPasajero = new Pasajero();

    $arregloPasajerosPorID = $objPasajero->listarReferenciasPorID($this->getCodigo());

    if ($arregloPasajerosPorID != null) {
        $cantPasajerosPorId = count($arregloPasajerosPorID);
    }else {
        $cantPasajerosPorId = 0;
    }

    

    if ($cantPasajerosPorId  >= $cant) {
        
        echo("ERROR-> No hay asientos disponibles---La cantidad maxima de pasajeros es: ".$cant." y hay cargados: ".$cantPasajerosPorId ." pasajeros");
    }else{

        
    echo ("\nCarga de Pasajeros: \n");

    while ($cantPasajerosPorId < $cant && $seguir) {

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

        $objPasajero->cargar($doc, $nombre, $apellido, $telefono, $this);
        

        // Inserto el OBj Pasajero en la base de datos
        $respuesta = $objPasajero->insertar();
        if ($respuesta == true) {
            echo "\n/\/\/El Pasajero fue ingresado Con Exito\/\/\ \n";

            //actualizo la cantidad de pasajeros cargados 
            $arregloPasajerosPorID = $objPasajero->listarReferenciasPorID($this->getCodigo());
            $cantPasajerosPorId = count($arregloPasajerosPorID);

          /*   array_push($arrayPasajeros, $objPasajero); */
      /*       $this->setColeccion_pasajeros($arrayPasajeros); */

        } else {
            echo $objPasajero->getmensajeoperacion();
        }
        $i++;

        if ($cantPasajerosPorId < $cant) {
            echo ("¿Desea agregar el proximo pasajero? \n 1-Si \n 2-No \n");
            $opcion = trim(fgets(STDIN));
            if ($opcion == 2) {
                $seguir = false;
            }
        }
    }

    }

}



    //toString
    public function __toString()
    {
        return "\n ID Viaje: " . $this->getCodigo() .
            "\n Destino: " . $this->getDestino() .
            "\n Cantidad Maxima de Pasajeros: " . $this->getCantMaxPasajeros() .
            "\n Importe: " . $this->getImporte().
            "\n tipo Asiento: " . $this->getTipoAsiento().
            "\n idaYvuelta: " . $this->getIdaYvuelta()."\n".
            "\n -Empresa- :\n ". $this->getEmpresa() ."\n".
            "\n -Responsable Del Viaje- : " . $this->getResponsableViaje();

          /*   "\n Pasajeros:\n" . $this->mostrar_coleccion_pasajero(); */
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
    	


    /**FUNCIONES ORM */
    /**INSERT */
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
         /**idviaje, vdestino, vcantmaxpasajeros,  idempresa, rnumeroempleado, vimporte, tipoAsiento, idayvuelta */
		$consultaInsertar="INSERT INTO viaje(idviaje, vdestino, vcantmaxpasajeros,  idempresa, rnumeroempleado, vimporte, tipoAsiento, idayvuelta) 
				VALUES ('".$this->getCodigo()."','".$this->getDestino()."','".$this->getCantMaxPasajeros()."','".$this->getEmpresa()->getIdEmpresa()."','".$this->getResponsableViaje()->getNroEmpleado()."','".$this->getImporte()."','".$this->getTipoAsiento()."','".$this->getIdaYvuelta()."' )";
		
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){

              /*   $idInsercion = $base->devuelveIDInsercion($consultaInsertar);
                $resp=  $idInsercion ;   */
			    $resp=  true; 

			}	else {
					$this->setmensajeoperacion($base->getError());
					
			}

		} else {
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}
	
    /**UPDATE */
    public function modificar(){
	    $resp =false; 
	    $base=new BaseDatos();
        /**idviaje, vdestino, vcantmaxpasajeros,  idempresa, rnumeroempleado, vimporte, tipoAsiento, idayvuelta */
		$consultaModifica="UPDATE viaje SET vdestino='".$this->getDestino()."', vcantmaxpasajeros='".$this->getCantMaxPasajeros().
                            "',idempresa='".$this->getEmpresa()->getIdEmpresa()."', rnumeroempleado='".$this->getResponsableViaje()->getNroEmpleado().
                            "',vimporte='".$this->getImporte()."', tipoAsiento='".$this->getTipoAsiento()."', idayvuelta='".$this->getIdaYvuelta().
                            "' WHERE idviaje=". $this->getCodigo();
		if($base->Iniciar()){
			if($base->Ejecutar($consultaModifica)){
			    $resp=  true;
			}else{
				$this->setmensajeoperacion($base->getError());				
			}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp;
	}

    /**DELETE */
    public function eliminar(){
		$base=new BaseDatos();
		$resp=false;
		if($base->Iniciar()){
				$consultaBorrar="DELETE FROM viaje WHERE idviaje=".$this->getCodigo();
				if($base->Ejecutar($consultaBorrar)){
				    $resp=  true;
				}else{
						$this->setmensajeoperacion($base->getError());
					
				}
		}else{
				$this->setmensajeoperacion($base->getError());
			
		}
		return $resp; 
	}

    /** BUSCAR
	 * Recupera los datos de un viaje por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function buscar($codigo){
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje where idviaje=".$codigo;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){
				if($registro=$base->Registro()){					
				    $this->setCodigo($codigo); 
					$this->setDestino($registro['vdestino']); 

                    $objEmpresa= new Empresa();
                    $objEmpresa->buscar($registro['idempresa']);
					$this->setEmpresa($objEmpresa);

					$this->setCantMaxPasajeros($registro['vcantmaxpasajeros']);

                    $objResponsable= new ResponsableV();
                    $objResponsable->buscar($registro['rnumeroempleado']);
                    $this->setResponsableViaje($objResponsable);

                    $this->setImporte($registro['vimporte']);
                    $this->setTipoAsiento($registro['tipoAsiento']);
                    $this->setIdaYvuelta($registro['idayvuelta']);
					$resp= true;
				}				
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 }		
		 return $resp;
	}	
    

    /**LISTAR */
    public function listar($condicion){
	    $arregloViaje = null;
		$base=new BaseDatos();
		$consultaViaje="Select * from viaje ";
		if ($condicion!=""){
		    $consultaViaje=$consultaViaje.' where '.$condicion;
		}
		$consultaViaje.=" order by idviaje ";
		//echo $consultaViaje;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaViaje)){				
				$arregloViaje= array();
				while($registro=$base->Registro()){
                  
                    $viaje=new Viaje();
                    $viaje->buscar( $registro['idviaje']);
                    
					array_push($arregloViaje,$viaje);              
				}
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloViaje;
	}	




}

?>