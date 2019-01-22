<?php

namespace Entity;

use Entity\Connect;
use Config\Config;

class Logs extends Connect {
	// properties
	private $idlog;
		
	const TABLA = "Logs";

	public function __construct(){
		parent::__construct();
	}

	// setters para obtencion de datos
	public function setIdlog($idlog) {
		$Config = new Config();
		$this->idlog = $Config->encrypt($idlog, 'decrypt');
	}
	
	//metodos para CRUD database
	public function create($data){
		$Query = $this->prepare("INSERT INTO ".self::TABLA." (ip, device) VALUES (:ip, :device)");

		$Query->execute($data);
		
		return $this->lastInsertId();
	}

	public function read($col='*', $property = NULL, $value = NULL, $limit='25'){
		$complement = (!empty($property) && !empty($value)) ? "WHERE ".$property." = ".$value : '';
		
		$Query = $this->prepare("SELECT ".$col." FROM ".self::TABLA." $complement ORDER BY idlog LIMIT ".$limit);

		$Query->execute();

		return $Query->fetchAll($this::FETCH_ASSOC);		
	}

	public function row($col='*', $property = NULL, $value = NULL){
		if ($this->idlog) {
			$complement = (!empty($property) && !empty($value)) ? "WHERE idlog = :idlog AND ".$property." = ".$value : '';
		}else{
			$complement = (!empty($property) && !empty($value)) ? "WHERE ".$property." = ".$value : '';
		}
		
		
		$Query = $this->prepare("SELECT ".$col." FROM ".self::TABLA." ".$complement);

		$Query->bindParam(":idlog", $this->idlog);

		$Query->execute();
		
		return $Query->fetch($this::FETCH_ASSOC);		
	}

	public function update($data){
		$property = ""; $i=0;
	  	foreach ($data as $name => $value) {
			if ($i==0) {
				$property .=  str_replace(":", "", $name)." = ".$name; 	
			}else{
				$property .=  ", ".str_replace(":", "", $name)." = ".$name;
			}
			$i++;    	
		}	    
	    $Query = $this->prepare("UPDATE ".self::TABLA." SET ".$property." WHERE idlog = ".$this->idlog);

	  	return $Query->execute($data);
	}

	public function delete(){			
		$Query = $this->prepare("DELETE FROM ".self::TABLA." WHERE idlog = :idlog");
		
		$Query->bindParam(":idlog", $this->idlog);
	  	
	  	return $Query->execute();
	}
}
	