<?php 

namespace Controllers;

use Config\Config;
use Entity\Usuarios;
use Entity\Asesores;
use Entity\Logs;

class LogController extends Config {

	public function home() {
		$this->render('sign/in.twig');
	}

	public function lastSession($idUser){
		$Log = new Logs;
		$Log->setIdUser($idUser);
		return $Log->read();
	}

	public function in() {

		extract($_POST);
		$User = new Usuarios;
		$Advisor = new Asesores;

		$User->setEmail($email);
		$row = $User->read('*', 'email', "'".$email."'", true);
		if($User->check($pass)){
			$Advisor->setIdUser($this->openCypher($row['idUser']));
			if ($Advisor->row()) {
				extract($Advisor->row('name, avatar'));
			}else{
				switch ($row['role']) {
					case 'SADMIN':
						$name = "Super Administrador";
						$avatar = "man.svg";
						break;
					
					case 'ADMIN':
						$name = "Administrador";
						$avatar = "woman_1.svg";
						break;
				}
			}
			

			$_SESSION['LastActivity'] = $_SERVER['REQUEST_TIME'];			
			$_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
			$_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION['active'] = true;
			$_SESSION['alert'] = false;

			$_SESSION['ID'] = $this->openCypher($row['idUser']);
			$_SESSION['EMAIL'] = $email;
			$_SESSION['START_TIME'] = time();
			$_SESSION['ROLE'] = $row['role'];
			$_SESSION['NAME'] = $name;
			$_SESSION['AVATAR'] = $avatar;

			$Log = new Logs;
			$Log->setIdUser($this->openCypher($row['idUser']));
			$Log->setIp($_SERVER['REMOTE_ADDR']);
			$Log->setDevice($_SERVER['HTTP_USER_AGENT']);
			$Log->save();

			header("Location: /dashboard");	
		}else{
			if (!empty($row)) {
				extract($row);		
				
				if(!$active){
					$msj='<strong>Notificacion:</strong> El usuario no se encuentra activo.';
					$type='warning';
				}else{
					$msj='<strong>Error 1:</strong> El usuario y/o contraseña son incorrectos.';
					$type='danger';
				}
			}else{				

				$msj='<strong>Error 2:</strong> El usuario y/o contraseña son incorrectos.';
				$type='danger';
			}
		}	
	
		$this->render('sign/in.twig', array(
			"type_alert"  => $type,
			"msj_alert"    => $msj,
		));	
	}

	public function out(){
		session_destroy();
		unset($_SESSION);
		header("Location: /");
	}
}
