<?php
include_once("./BaseDeDatos/BaseDatos.php");

class ResponsableV{

//atributos
private $nroEmpleado;
private $nroLicencia;
private $nombre;
private $apellido;
private $mensajeoperacion;

//constructor
public function __construct(){
    $this->nroEmpleado = "";
    $this->nroLicencia = "";
    $this->nombre = "";
    $this->apellido = "";
}

public function cargar($nroEmpleado, $nroLicencia, $nombre, $apellido){

     $this->setNroEmpleado($nroEmpleado);
     $this->setNroLicencia($nroLicencia);
     $this->setNombre($nombre);
     $this->setApellido($apellido);
}



//metodos Getters
public function getNombre(){
    return $this->nombre;
}

public function getApellido(){
    return $this->apellido;
}

public function getNroEmpleado(){
    return $this->nroEmpleado;
}

public function getNroLicencia(){
    return $this->nroLicencia;
}

//metodos Setters
public function setNombre($nombre){
    $this->nombre = $nombre;
}

public function setApellido($apellido){
    $this->apellido = $apellido;
}

public function setNroEmpleado($nroEmpleado){
    $this->nroEmpleado = $nroEmpleado;
}

public function setNroLicencia($nroLicencia){
    $this->nroLicencia = $nroLicencia;
}

public function getmensajeoperacion(){
    return $this->mensajeoperacion ;
}
public function setmensajeoperacion($mensajeoperacion){
    $this->mensajeoperacion=$mensajeoperacion;
}


//metodo Tostring
public function __toString(){
    return "\n  ". $this->getNombre()." ".$this->getApellido()."\n".
            "  Nro Empleado: ".$this->getNroEmpleado()."\n".
            "  Nro Licencia: ".$this->getNroLicencia()."\n";
}



    /**FUNCIONES ORM */
    /**INSERT */
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
         /**rnumeroempleado, rnumerolicencia, rnombre, rapellido */
		$consultaInsertar="INSERT INTO responsable(rnumerolicencia, rnombre, rapellido) 
				VALUES ('".$this->getNroLicencia()."','".$this->getNombre()."','".$this->getApellido()."')";
	
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
        /**rnumeroempleado, rnumerolicencia, rnombre, rapellido */
		$consultaModifica="UPDATE responsable SET rnumerolicencia='".$this->getNroLicencia()."', rnombre='".$this->getNombre()."', rapellido='".$this->getApellido()."' WHERE rnumeroempleado='".$this->getNroEmpleado()."' ";
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
				$consultaBorrar="DELETE FROM responsable WHERE rnumeroempleado=".$this->getNroEmpleado();
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
    public function buscar($nroEmpleado){
		$base=new BaseDatos();
		$consultaResponsable="Select * from responsable where rnumeroempleado=".$nroEmpleado;
		$resp=false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){
				if($registro=$base->Registro()){	
                     /**rnumeroempleado, rnumerolicencia, rnombre, rapellido */				
				    $this->setNroEmpleado($nroEmpleado);
					$this->setNroLicencia($registro['rnumerolicencia']);
					$this->setNombre($registro['rnombre']);
					$this->setApellido($registro['rapellido']);
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
	    $arregloResponsable = null;
		$base=new BaseDatos();
		$consultaResponsable="Select * from responsable ";
		if ($condicion!=""){
		    $consultaResponsable=$consultaResponsable.' where '.$condicion;
		}
		$consultaResponsable.=" order by rnumeroempleado";
		//echo $consultaResponsable;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaResponsable)){				
				$arregloResponsable= array();
				while($registro=$base->Registro()){
					 /**rnumeroempleado, rnumerolicencia, rnombre, rapellido */		
					
					$responsable=new ResponsableV();
					$responsable->buscar($registro['rnumeroempleado']);

					array_push($arregloResponsable,$responsable);              
				}
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloResponsable;
	}	











}
?>