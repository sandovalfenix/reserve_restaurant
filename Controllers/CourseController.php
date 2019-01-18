<?php 

namespace Controllers;

use Config\Config;
use Entity\Cursos;

class CourseController extends Config  {

	public function crud() {		
		$this->render('dashboard/courses/data.twig', array(
			'alert' => $_SESSION['alert'],
		));

		$_SESSION['alert'] = false;
	}
	
	public function new(){
		extract($_POST);
		$Event = new Cursos;
		
		$Event->setName($name);
		$Event->setDateStart($dateStart);
		$Event->setDateFinal($dateFinal);
		$Event->setStatus('Inscripción');

		if($Event->save()){
			$type = 'success';
			$msj = 'El Evento fue "Añadido" Correctamente!'; 
		}else{
			$type = 'danger';
			$msj = 'El Evento "no se pudo completar!". Error DB';
		}

		$_SESSION['alert'] = array(
			'type' => $type,
			'msj' => $msj, 
		);

		header('location: /course/crud');
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