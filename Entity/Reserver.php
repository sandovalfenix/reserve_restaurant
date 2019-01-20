<?php

namespace Entity;

use Entity\Connect;
use Config\Config;

class Reserver extends Connect {
	// properties
	private $idReserver;
		
	const TABLA = "Reserver";

	public function __construct(){
		parent::__construct();
	}

	// setters para obtencion de datos
	public function setIdReserver($idReserver) {
		$Config = new Config();
		$this->idReserver = $Config->encrypt($idReserver, 'decrypt');
	}
	
	//metodos para CRUD database
	public function create($data){
		$Query = $this->prepare("INSERT INTO ".self::TABLA." (dateReserver, timeReserver, nameCustomer, phoneCustomer, emailCustomer, numPerson, typeReserver, description, venues) VALUES (:dateReserver, :timeReserver, :nameCustomer, :phoneCustomer, :emailCustomer, :numPerson, :typeReserver, :description, :venues)");

		$Query->execute($data);
		
		return $this->lastInsertId();
	}

	public function read($col='*', $property = NULL, $value = NULL, $limit='25'){
		$complement = (!empty($property) && !empty($value)) ? "WHERE ".$property." = ".$value : '';
		
		$Query = $this->prepare("SELECT ".$col." FROM ".self::TABLA." $complement ORDER BY idReserver LIMIT ".$limit);

		$Query->execute();

		return $Query->fetchAll($this::FETCH_ASSOC);		
	}

	public function row($col='*', $property = NULL, $value = NULL){
		$complement = (!empty($property) && !empty($value)) ? "AND ".$property." = ".$value : '';
		
		$Query = $this->prepare("SELECT ".$col." FROM ".self::TABLA." WHERE idReserver = :idReserver ".$complement);

		$Query->bindParam(":idReserver", $this->idReserver);

		$Query->execute();
		
		return $Query->fetch($this::FETCH_ASSOC);		
	}

	public function update($data){
		$property = "";
	  	foreach ($data as $name => $value) {
			if ($name === reset($data)) {
				$property =  $name." = :".$name;    	
			}else{
				$property =  ",".$name." = :".$name;
			}    	
		}		    
	    $Query = $this->prepare("UPDATE ".self::TABLA." SET ".$property." WHERE idReserver = :idReserver");
	 	
	 	$Query->bindParam(":idReserver", $this->idReserver);

	  	return $Query->execute($data);
	}

	public function delete(){			
		$Query = $this->prepare("DELETE FROM ".self::TABLA." WHERE idReserver = :idReserver");
		
		$Query->bindParam(":idReserver", $this->idReserver);
	  	
	  	return $Query->execute();
	}
}
	