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

		$this->render('home/receipt.twig', array(
			'Reserver' => $Reserver->read('*',true,'idReserver',$id),
		));
	}

	public function crud() {		
		$this->render('dashboard/courses/data.twig', array(
			'alert' => $_SESSION['alert'],
		));

		$_SESSION['alert'] = false;
	}

	public function read(){
		$Event = new Cursos;

		$rows = $Event->read();
		$jsEvent = '[';
		$i=0;
		foreach ($rows as $row) {
		if ($i>0) {
			$jsEvent .=',';
		}
		$id = $this->openCypher($row['idCourse']);
		$jsEvent .= '
			{
	            "title": "'.$row['name'].'", 
	            "start": "'.$row['dateStart'].'", 
	            "end": "'.$row['dateFinal'].'", 
	            "type": "info", 
	            "typeTitle": "E",';
	            	if($_SESSION['ROLE'] == 'SADMIN' OR $_SESSION['ROLE'] == 'ADMIN'){
	        $jsEvent .= '"desc": "<h3><a href=\'javascript:void(0)\' data-idEditModal='.$id.' data-toggle=\'modal\' data-target=\'#modalCourse\' title=\'Editar\' class=\'text-warning fas fa-edit\'></a> | <a href=\'javascript:void(0)\' data-idRemoveModal='.$id.' data-toggle=\'modal\' data-target=\'#deletedEvent\' title=\'Eliminar\' class=\'text-danger fas fa-trash\'></a></h3>",';
	            	}else{
	         			$jsEvent .= '"desc": "",';
	            	}
	            $jsEvent .= '   
	            "color": "#'.substr(md5(mt_rand()),0,6).'75"
	        }';
	    $i++;
		}
		$jsEvent .= ']';

		echo $jsEvent;
	}

	public function editForm($id){
		$Event = new Cursos;
		$Event->setIdCourse($id);
		$this->render('dashboard/courses/form.twig', array(
			'Course' => $Event->row(),
		));
	}

	public function update(){
		extract($_POST);
		$Event = new Cursos;
		$Event->setIdCourse($idCourse);
		
		$Event->update("name", "'".$name."'");
		$Event->update("dateStart", "'".$dateStart."'");
		$Event->update("dateFinal", "'".$dateFinal."'");

		$type = 'info';

    
		$msj = 'El Evento fue Actualizado Correctamente'; 
		
		$_SESSION['alert'] = array(
			'type' => $type,
			'msj' => $msj, 
		);

		header('location: /course/crud');
	}

	public function delete($id){
		$Event = new Cursos;
		$Event->setIdCourse($id);
		
		$Event->delete();

		$type = 'danger';

    
		$msj = 'El Evento fue Eliminado Correctamente'; 
		
		$_SESSION['alert'] = array(
			'type' => $type,
			'msj' => $msj, 
		);

		header('location: /course/crud');
	}
}
