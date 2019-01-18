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

	public function createEntity($script){	
		$addEntity = new addEntity;
		$addEntity->createEntity($script);
	}
}
