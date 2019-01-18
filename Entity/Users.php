<?php

namespace Entity;

use Entity\Connect;
use Config\Config;

class Users extends Connect {
	// properties
	private $idUser;
		
	const TABLA = "Users";

	public function __construct(){
		parent::__construct();
	}

	// setters para obtencion de datos
	public function setIdUser($idUser) {
		$Config = new Config();
		$this->idUser = $Config->openCypher($idUser, 'decrypt');
	}
	
	//metodos para CRUD database
	public function create($data){
		$Query = $this->prepare("INSERT INTO ".self::TABLA." (username, password, active, role) VALUES (:username, :password, :active, :role)");

		$Query->execute($data);
		
		return $this->lastInsertId();
	}

	public function read($col='*', $row=false, $property = NULL, $value = NULL, $limit='25'){
		$complement = (!empty($property) && !empty($value)) ? "WHERE ".$createproperty." = ".$value : '';
		
		$Query = $this->prepare("SELECT ".$col." FROM ".self::TABLA." $complement ORDER BY idUser LIMIT ".$limit);

		$Query->execute();

		if($row){
			return $Query->fetch($this::FETCH_ASSOC);
		}else{
			return $Query->fetchAll($this::FETCH_ASSOC);
		}
		
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
	    $Query = $this->prepare("UPDATE ".self::TABLA." SET ".$property." WHERE idUser = :idUser");
	 	
	 	$Query->bindParam(":idUser", $this->idUser);

	  	return $Query->execute($data);
	}

	public function delete(){			
		$Query = $this->prepare("DELETE FROM ".self::TABLA." WHERE idUser = :idUser");
		
		$Query->bindParam(":idUser", $this->idUser);
	  	
	  	return $Query->execute();
	}
}
	