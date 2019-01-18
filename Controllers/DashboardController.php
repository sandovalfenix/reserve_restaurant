<?php 

namespace Controllers;

use Config\Config;
use Entity\addEntity;

/**
 * @role "SADMIN, ADMIN, ASESOR"
 */

class DashboardController extends Config {

	public function home() {
		$this->render('dashboard/index.twig');
	}
}
