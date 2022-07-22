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

public function cargar($nombre, $apellido, $nroDni, $telefono, $objViaje){
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
    return "  ". $this->getNombre()." ".$this->getApellido()."\n".
            "  Nro Dni: ".$this->getNroDni()."\n".
            "  Telefono: ".$this->getTelefono()."\n";
}


    /**FUNCIONES ORM */
    /**INSERT */
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
         /**rdocumento, pnombre, papellido, ptelefono, idviaje */
		$consultaInsertar="INSERT INTO pasajero(rdocumento, pnombre, papellido, ptelefono, idviaje ) 
				VALUES ('".$this->getNroDni()."','".$this->getNombre()."','".$this->getApellido()."','".$this->getTelefono()."','".$this->getViaje()->getCodigo()."')";
	
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
        /**rdocumento, pnombre, papellido, ptelefono, idviaje */
		$consultaModifica="UPDATE pasajero SET rdocumento='".$this->getNroDni()."', pnombre='".$this->getNombre().
                            "',papellido='".$this->getApellido()."', ptelefono='".$this->getTelefono()."', idviaje='".$this->getViaje()->getCodigo();
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
				$consultaBorrar="DELETE FROM pasajero WHERE rdocumento=".$this->getNroDni();
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
	 * Recupera los datos de una persona por dni
	 * @param int $dni
	 * @return true en caso de encontrar los datos, false en caso contrario 
	 */		
    public function Buscar($nroDni){
		$base=new BaseDatos();
		$consultaPasajero="Select * from pasajero where rdocumento=".$nroDni;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){
				if($row2=$base->Registro()){	
                     /**rdocumento, pnombre, papellido, ptelefono, idviaje */				
				    $this->setNroDni($nroDni);
					$this->setNombre($row2['pnombre']);
                    $this->setApellido($row2['papellido']);
					$this->setTelefono($row2['ptelefono']);
					$this->getViaje()->setCodigo($row2['idviaje']);
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
		$consultaPasajero.=" order by rdocumentoo";
		//echo $consultaPasajero;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPasajero)){				
				$arregloPasajero= array();
				while($row2=$base->Registro()){
					 /**rdocumento, pnombre, papellido, ptelefono, idviaje  */		
					$nroDni=$row2['rdocumento'];
					$nombre=$row2['pnombre'];
					$apellido=$row2['papellido'];
					$telefono= $row2['ptelefono'];
                    $objViaje= $this->getViaje()->getCodigo() $row2['idviaje'];

					$pasajero=new Pasajero();
					$pasajero->cargar($nroDni, $nombre, $apellido, $telefono, $objViaje);
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