<?php
namespace Entity;

use Entity\Connect; 


class addEntity extends Connect {
	public function __construct(){
		parent::__construct();
	}

	public function createEntity($db){
		
		$Query = $this->prepare('SHOW FULL TABLES FROM '.$db);
		$Query->execute();
		$arrays = $Query->fetchAll($this::FETCH_ASSOC);
		foreach ($arrays as $array => $tables) {

		$tabla = ucwords($tables['Tables_in_'.$db]);
		$Query = $this->prepare('SHOW COLUMNS FROM '.$tabla);
		$Query->execute();
		$arrays = $Query->fetchAll($this::FETCH_ASSOC);
		$properties = array();

		$atributos = '';
		$attr = '';
		$setter = '';
		$values = '';
		$bindParam = '';

		$i=0;
foreach ($arrays as $array => $property) {

if($property['Key'] == 'PRI'){ 
	$idProperty = $property['Field'];
}else{
	$attr .= ($i == 1) ? $property['Field'] : ", ".$property['Field'];
	$values .= ($i == 1) ? ":".$property['Field'] : ", :".$property['Field'];
	$bindParam .= "\$Query->bindParam(\":".$property['Field']."\", \$this->".$property['Field'].");\n\t\t";	
}
if ($property['Key'] == 'PRI' || $property['Key'] == 'MUL') {
	$atributos .= "private \$".$property['Field'].";\n\t";
	$setter .= "public function set".ucwords($property['Field'])."(\$".$property['Field'].") {
		\$Config = new Config();
		\$this->".$property['Field']." = \$Config->openCypher(\$".$property['Field'].", 'decrypt');
	}\n\t";	
}

$i++;
}

$new_file = fopen(__ROOT__.'Entity/'.$tabla.".php", "w+");
fwrite($new_file,"<?php

namespace Entity;

use Entity\Connect;
use Config\Config;

class ".$tabla." extends Connect {
	// properties
	".$atributos."	
	const TABLA = \"$tabla\";

	public function __construct(){
		parent::__construct();
	}

	// setters para obtencion de datos
	".$setter."
	//metodos para CRUD database
	public function create(\$data){
		\$Query = \$this->prepare(\"INSERT INTO \".self::TABLA.\" (".$attr.") VALUES (".$values.")\");

		\$Query->execute(\$data);
		
		return \$this->lastInsertId();
	}

	public function read(\$col='*', \$row=false, \$property = NULL, \$value = NULL, \$limit='25'){
		\$complement = (!empty(\$property) && !empty(\$value)) ? \"WHERE \".\$createproperty.\" = \".\$value : '';
		
		\$Query = \$this->prepare(\"SELECT \".\$col.\" FROM \".self::TABLA.\" \$complement ORDER BY ".$idProperty." LIMIT \".\$limit);

		\$Query->execute();

		if(\$row){
			return \$Query->fetch(\$this::FETCH_ASSOC);
		}else{
			return \$Query->fetchAll(\$this::FETCH_ASSOC);
		}
		
	}

	public function update(\$data){
		\$property = \"\";
	  	foreach (\$data as \$name => \$value) {
			if (\$name === reset(\$data)) {
				\$property =  \$name.\" = :\".\$name;    	
			}else{
				\$property =  \",\".\$name.\" = :\".\$name;
			}    	
		}		    
	    \$Query = \$this->prepare(\"UPDATE \".self::TABLA.\" SET \".\$property.\" WHERE ".$idProperty." = :".$idProperty."\");
	 	
	 	\$Query->bindParam(\":$idProperty\", \$this->".$idProperty.");

	  	return \$Query->execute(\$data);
	}

	public function delete(){			
		\$Query = \$this->prepare(\"DELETE FROM \".self::TABLA.\" WHERE ".$idProperty." = :".$idProperty."\");
		
		\$Query->bindParam(\":$idProperty\", \$this->".$idProperty.");
	  	
	  	return \$Query->execute();
	}
}
	");

	fclose($new_file);
			echo "<h1>Tabla ".$tabla." fue creada con exito</h1>";		
		}
	}
}

