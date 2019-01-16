<?php 

namespace Controllers;

use Config\Config;
use Entity\addEntity;

/**
 * @start "Homepage"
 */
class DefaultController extends Config {

	public function home() {
		$this->render('home/index.twig');
	}

	public function scriptSQL(){
		extract($_POST);		
		$addEntity = new addEntity;
		$addEntity->scriptSQL($script);
	}
}
