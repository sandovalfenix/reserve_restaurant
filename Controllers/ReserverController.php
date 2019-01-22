<?php 

namespace Controllers;

use Config\Config;
use Entity\Reserver;
use Entity\Logs;

/**
 * @start "Homepage"
 */
class ReserverController extends Config {

	public function home() {
		$Log = new Logs;
		$Log->create(array(
			':ip' => $_SERVER['REMOTE_ADDR'],
			':device' => $_SERVER['HTTP_USER_AGENT']
		));
		$this->render('home/index.twig');
	}

	public function make() {
		$Reserver = new Reserver;
		$id = $Reserver->create($_POST);
		if($id){
			$this->sendEmail($id);
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

	public function sendEmail($id){
		$Reserver = new Reserver;	
		$Reserver->setIdReserver($this->encrypt($id));
		extract($Reserver->row('emailCustomer'));
		$body= file_get_contents($_SERVER['HTTP_HOST'].'/reserver/receipt/'.$id);
		$this->phpMailer('reserva@cafevalparaiso.com', $emailCustomer, $body, 'Reservas Cafe Valparaiso');
	}

	public function crud() {		
		$this->render('dashboard/reservers/data.twig', array(
			'alert' => $_SESSION['alert'],
		));

		$_SESSION['alert'] = false;
	}

	public function read(){
		$Reservers = new Reserver;
		$jsReserver = '[';
		$i=0;
		foreach ($Reservers->read('*', 'venues', $_SESSION['ROLE']) as $Reserver) {
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

	public function update($id){		
		$Reserver = new Reserver;
		$Reserver->setIdReserver($id);

		if($Reserver->update($_POST)){
			$type = 'info';
    
			$msj = 'La Reserva fue Actualizada Correctamente'; 
			
			$_SESSION['alert'] = array(
				'type' => $type,
				'msj' => $msj, 
			);
		}else{
			$type = 'danger';
    
			$msj = 'Error al Actualizar la Reserva'; 
			
			$_SESSION['alert'] = array(
				'type' => $type,
				'msj' => $msj, 
			);
		}		

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
