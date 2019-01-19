<?php 

namespace Controllers;

use Config\Config;
use Entity\addEntity;


class DashboardController extends Config {

	public function home() {
		$this->render('dashboard/index.twig');
	}
}
