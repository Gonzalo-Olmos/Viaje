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
		$consultaInsertar="INSERT INTO responsable(rnumeroempleado, rnumerolicencia, rnombre, rapellido) 
				VALUES ('".$this->getNroEmpleado()."','".$this->getNroLicencia()."','".$this->getNombre()."','".$this->getApellido()."')";
	
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
		$consultaModifica="UPDATE responsable SET rnumeroempleado='".$this->getNroEmpleado()."', rnumerolicencia='".$this->getNroLicencia().
                            "',rnombre='".$this->getNombre()."', rapellido='".$this->getApellido();
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
    public function Buscar($nroEmpleado){
		$base=new BaseDatos();
		$consultaPersona="Select * from responsable where rnumeroempleado=".$nroEmpleado;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaPersona)){
				if($row2=$base->Registro()){	
                     /**rnumeroempleado, rnumerolicencia, rnombre, rapellido */				
				    $this->setNroEmpleado($nroEmpleado);
					$this->setNroLicencia($row2['rnumerolicencia']);
					$this->getNombre($row2['rnombre']);
					$this->setApellido($row2['rapellido']);
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
				while($row2=$base->Registro()){
					 /**rnumeroempleado, rnumerolicencia, rnombre, rapellido */		
					$nroEmpleado=$row2['rnumeroempleado'];
					$nroLicencia=$row2['rnumerolicencia'];
					$nombre=$row2['rnombre'];
					$apellido= $row2['rapellido'];
					$responsable=new ResponsableV();
					$responsable->cargar($nroEmpleado, $nroLicencia, $nombre, $apellido);
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