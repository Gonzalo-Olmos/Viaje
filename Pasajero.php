<?php
include_once("./BaseDeDatos/BaseDatos.php");
include("Viaje.php");

class Pasajero{

//atributos
private $nroDni;
private $nombre;
private $apellido;
private $telefono;
private $objViaje;
private $mensajeoperacion;

//constructor
public function __construct(){
    $this->nombre = "";
    $this->apellido = "";
    $this->nroDni = "";
    $this->telefono = "";
    $this->objViaje= new Viaje();
}

public function cargar( $nroDni, $nombre, $apellido,$telefono, $objViaje){
    $this->setNombre($nombre);
    $this->setApellido($apellido);
    $this->setNroDni($nroDni);
    $this->setTelefono($telefono);
    $this->setViaje($objViaje);
}



//metodos Getters
public function getNombre(){
    return $this->nombre;
}

public function getApellido(){
    return $this->apellido;
}

public function getNroDni(){
    return $this->nroDni;
}

public function getTelefono(){
    return $this->telefono;
}

public function getViaje(){
    return $this->objViaje;
}

public function getmensajeoperacion(){
    return $this->mensajeoperacion ;
}
public function setmensajeoperacion($mensajeoperacion){
    $this->mensajeoperacion=$mensajeoperacion;
}


//metodos Setters
public function setNombre($nombre){
    $this->nombre = $nombre;
}

public function setApellido($apellido){
    $this->apellido = $apellido;
}

public function setNroDni($nroDni){
    $this->nroDni = $nroDni;
}

public function setTelefono($telefono){
    $this->telefono = $telefono;
}


public function setViaje($objViaje){
    $this->objViaje = $objViaje;
}



//metodo Tostring
public function __toString(){
    return " ". $this->getNombre()." ".$this->getApellido()."\n".
            "  Nro Dni: ".$this->getNroDni()."\n".
            "  Telefono: ".$this->getTelefono()."\n".
			"  idViaje: ".$this->getViaje()->getCodigo()."\n";
}


    /**FUNCIONES ORM */
    /**INSERT */
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
         /**pdocumento, pnombre, papellido, ptelefono, idviaje */
		$consultaInsertar="INSERT INTO pasajero(pdocumento, pnombre, papellido, ptelefono, idviaje ) 
				VALUES ('".$this->getNroDni()."','".$this->getNombre()."','".$this->getApellido()."','".$this->getTelefono()."', '".$this->getViaje()->getCodigo()."')";
	
		if($base->Iniciar()){

			if($base->Ejecutar($consultaInsertar)){
				
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
        /**pdocumento, pnombre, papellido, ptelefono, idviaje */
		$pdocumento = $this->getNroDni();
		$pnombre = $this->getNombre();
		$papellido = $this->getApellido();
		$ptelefono = $this->getTelefono();
		$idviaje = $this->getViaje()->getCodigo();

		$consultaModifica="UPDATE pasajero SET papellido='".$papellido."',pnombre='".$pnombre."'
		,ptelefono=".$ptelefono.", idviaje=".$idviaje." WHERE pdocumento=".$pdocumento; 
		
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
				$consultaBorrar="DELETE FROM pasajero WHERE pdocumento=".$this->getNroDni();
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
	 * Recupera los datos de un Pasjero por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function buscar($nroDni){
		$base=new BaseDatos();
		$consultaPasajero="Select * from pasajero where pdocumento=".$nroDni;
		$resp= false;

		if($base->Iniciar()){
			
			if($base->Ejecutar($consultaPasajero)){
				
				if($registro=$base->Registro()){	
                     /**pdocumento, pnombre, papellido, ptelefono, idviaje */				
				    $this->setNroDni($nroDni);
					$this->setNombre($registro['pnombre']);
                    $this->setApellido($registro['papellido']);
					$this->setTelefono($registro['ptelefono']);
					$objViaje = new Viaje();
					$objViaje->buscar($registro['idviaje']);
					$this->setViaje($objViaje);
				
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
    public function listar($condicion=""){
	    $arregloPasajero = null;
		$base=new BaseDatos();
		$consultaPasajero="Select * from pasajero ";
		if ($condicion!=""){
		    $consultaPasajero=$consultaPasajero.' where '.$condicion;
		}
		$consultaPasajero.=" order by pdocumentoo";
		//echo $consultaPasajero;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){				
				$arregloPasajero= array();
				while($registro=$base->Registro()){
					 /**pdocumento, pnombre, papellido, ptelefono, idviaje  */		

					$pasajero=new Pasajero();
					$pasajero->buscar($registro['pdocumento']);
					
					array_push($arregloPasajero,$pasajero);              
				}
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloPasajero;
	}	


/**
 * Esta funcion retorna un arreglo con los registros relacionados con la el id dado
 * @param int id
 * @return Array de registros vinculados con el id 
 */
	public function listarReferenciasPorID($id){
	    $arregloPasajero = null;
		$base=new BaseDatos();
		$consultaPasajero="Select * from pasajero where idviaje = ".$id;
	
		/* echo $consultaPasajero; */
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){				
				$arregloPasajero= array();
				while($registro=$base->Registro()){
					 /**pdocumento, pnombre, papellido, ptelefono, idviaje  */		

					$pasajero=new Pasajero();
					$pasajero->buscar($registro['pdocumento']);

					array_push($arregloPasajero,$pasajero);              
				}
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloPasajero;
	}	


}
?>