<?php 

namespace Controllers;

use Config\Config;
use Entity\Users;

class LogController extends Config {

	public function home() {
		$this->render('sign/in.twig');
	}

	public function in() {

		extract($_POST);
		$User = new Users;
		$id = $User->check($username, $pass);
		if($id){
			$User->setIdUser($id);
			extract($User->row());

			$_SESSION['LastActivity'] = $_SERVER['REQUEST_TIME'];			
			$_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
			$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['active'] = true;
			$_SESSION['alert'] = false;

			$_SESSION['ID'] = $this->encrypt($idUser);
			$_SESSION['USERNAME'] = $username;
			$_SESSION['START_TIME'] = time();
			$_SESSION['ROLE'] = $role;

			header("Location: /dashboard");	

		}else{	
			$msj='<strong>Error 1:</strong> El usuario y/o contraseña son incorrectos.';
			$type='danger';
		}	
	
		$this->render('sign/in.twig', array(
			"type_alert"  => $type,
			"msj_alert"    => $msj,
		));	
	}

	public function out(){
		session_destroy();
		unset($_SESSION);
		header("Location: /dashboard");
	}
}
