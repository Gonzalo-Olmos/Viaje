<?php

class Empresa{

//atributos
private $idEmpresa;
private $enombre;
private $edireccion;
private $mensajeoperacion;


//constructor
public function __construct(){
    $this->idEmpresa = "";
    $this->enombre = "";
    $this->edireccion = "";
}

public function cargar($idEmpresa, $enombre, $edireccion){

    $this->setIdEmpresa($idEmpresa);
    $this->setEnombre($enombre);
    $this->setEdireccion($edireccion);
}

//metodos Getters
public function getIdEmpresa(){
    return $this->idEmpresa;
}

public function getEnombre(){
    return $this->enombre;
}

public function getEdireccion(){
    return $this->edireccion;
}

//metodos Setters
public function setIdEmpresa($idEmpresa){
    $this->idEmpresa = $idEmpresa;
}

public function setEnombre($enombre){
    $this->enombre = $enombre;
}

public function setEdireccion($edireccion){
    $this->edireccion = $edireccion;
}

public function getmensajeoperacion(){
    return $this->mensajeoperacion ;
}
public function setmensajeoperacion($mensajeoperacion){
    $this->mensajeoperacion=$mensajeoperacion;
}

//metodo Tostring
public function __toString(){
    return " Id Empresa: ". $this->getIdEmpresa()."\n".
            " Nombre Empresa: ".$this->getEnombre()."\n".
            " Direccion Empresa: ".$this->getEdireccion()."\n";
}



    /**FUNCIONES ORM */
    /**INSERT */
	public function insertar(){
		$base=new BaseDatos();
		$resp= false;
         /**idEmpresa, enombre, edireccion */
		$consultaInsertar="INSERT INTO empresa(idEmpresa, enombre, edireccion) 
				VALUES ('".$this->getIdEmpresa()."','".$this->getEnombre()."','".$this->getEdireccion()."')";
	
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
        /**idEmpresa, enombre, edireccion */
		$consultaModifica="UPDATE empresa SET idEmpresa='".$this->getIdEmpresa()."', enombre='".$this->getEnombre().
                            "',edireccion='".$this->getEdireccion();
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
				$consultaBorrar="DELETE FROM empresa WHERE idEmpresa=".$this->getIdEmpresa();
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
    public function buscar($idEmpresa){
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa where idempresa=".$idEmpresa;
		$resp= false;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){
				if($registro=$base->Registro()){	
                     /**idempresa, enombre, edireccion*/				
				    $this->setIdEmpresa($idEmpresa);
					$this->setEnombre($registro['enombre']);
                    $this->setEdireccion($registro['edireccion']);						
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
	    $arregloEmpresa = null;
		$base=new BaseDatos();
		$consultaEmpresa="Select * from empresa ";
		if ($condicion!=""){
		    $consultaEmpresa=$consultaEmpresa.' where '.$condicion;
		}
		$consultaEmpresa.=" order by idempresa";
		//echo $consultaEmpresa;
		if($base->Iniciar()){
			if($base->Ejecutar($consultaEmpresa)){				
				$arregloEmpresa= array();
				while($registro=$base->Registro()){
					 /**idempresa, enombre, edireccion */		

					$empresa=new empresa();
					$empresa->buscar($registro['idempresa']);

					array_push($arregloEmpresa,$empresa);              
				}
			
		 	}	else {
		 			$this->setmensajeoperacion($base->getError());
		 		
			}
		 }	else {
		 		$this->setmensajeoperacion($base->getError());
		 	
		 }	
		 return $arregloEmpresa;
	}	








}
?>