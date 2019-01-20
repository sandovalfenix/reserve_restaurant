<?php 

namespace Controllers;

use Config\Config;
use Entity\Reserver;


class ReserverController extends Config {

	public function make() {
		$Reserver = new Reserver;
		$id = $Reserver->create($_POST);
		if($id){
			$this->receipt($id);
		}else{
			echo 'error en la reserva';
		}
	}

	public function receipt($id) {
		$Reserver = new Reserver;	
		$Reserver->setIdReserver($this->encrypt($id));
		$this->render('home/receipt.twig', array(
			'Reserver' => $Reserver->row(),
		));
	}

	public function crud() {		
		$this->render('dashboard/reservers/data.twig', array(
			'alert' => @$_SESSION['alert'],
		));

		@$_SESSION['alert'] = false;
	}

	public function read(){
		$Reservers = new Reserver;
		$jsReserver = '[';
		$i=0;
		foreach ($Reservers->read() as $Reserver) {
			extract($Reserver);
			if ($i>0) {
				$jsReserver .=',';
			}
			$idReserver = $this->encrypt($idReserver);
			$typeReserver = ($typeReserver == 1) ? 'Sin Decoración' : 'Con Decoración - $30.000';
			$emailCustomer = ($emailCustomer) ? $emailCustomer : 'No tiene';
			$description = ($description) ? $description : 'Ninguno';
			$jsReserver .= '
			{
	            "id": "'.$idReserver.'",
	            "title": "'.$nameCustomer.'",
	            "request" : "'.$dateRequest.'",
	            "start": "'.$dateReserver.'T'.$timeReserver.'",
	            "type": "success", 
	            "typeTitle": "'.substr($nameCustomer,0,1).'",
	            "phone": "'.$phoneCustomer.'",
	            "email": "'.$emailCustomer.'",
	            "numPerson": "'.$numPerson.'",
	            "table": "'.$typeReserver.'",
	            "description" : "'.$description.'",
	            "color": "#'.substr(md5(mt_rand()),0,6).'75"
	        }';
	    	$i++;
		}
		$jsReserver .= ']';

		echo $jsReserver;
	}

	public function editForm($id){
		$Reserver = new Reserver;
		$Reserver->setIdReserver($id);
		$this->render('dashboard/reservers/form.twig', array(
			'Reserver' => $Reserver->row(),
		));
	}

	public function update(){
		extract($_POST);
		$Reserver = new Reserver;
		$Reserver->setIdReserver($idReserver);
		
		$Reserver->update("name", "'".$name."'");
		$Reserver->update("dateStart", "'".$dateStart."'");
		$Reserver->update("dateFinal", "'".$dateFinal."'");

		$type = 'info';

    
		$msj = 'La Reserva fue Actualizada Correctamente'; 
		
		$_SESSION['alert'] = array(
			'type' => $type,
			'msj' => $msj, 
		);

		header('location: /reserver/crud');
	}

	public function delete($id){
		$Reserver = new Reserver;
		$Reserver->setIdReserver($id);
		
		$Reserver->delete();

		$type = 'danger';

    
		$msj = 'La Reserva fue Eliminada Correctamente'; 
		
		$_SESSION['alert'] = array(
			'type' => $type,
			'msj' => $msj, 
		);

		header('location: /reserver/crud');
	}
}
