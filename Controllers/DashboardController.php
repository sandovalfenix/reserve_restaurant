<?php 

namespace Controllers;

use Config\Config;
use Entity\Logs;
use Entity\Reserver;


class DashboardController extends Config {

	public function home() {
		if (isset($_SESSION['ID'])) {
			$Logs = new Logs;
			$Reservers = new Reserver;
			$this->render('dashboard/index.twig', array(
				'Logs' => $Logs->row('count(idLog) as numViews'),
				'Reserver' => $Reservers->row('count(idReserver) as numReserverGlobal'),
				'Venues' => $Reservers->row('count(idReserver) as numReserverVenues', 'venues', $_SESSION['ROLE']),
				'VenuesDayNow' => $Reservers->row('count(idReserver) as numReserverVenues', 'venues', $_SESSION['ROLE'], 'AND dateReserver = "'.date('Y-m-d').'"'),
				'VenuesDayYes' => $Reservers->row('count(idReserver) as numReserverVenues', 'venues', $_SESSION['ROLE'], 'AND dateReserver = "'.date('Y-m-d', strtotime('-1 day')).'"'),
				'VenuesNumPersDayNow' => $Reservers->row('SUM(numPerson) as numPerson', 'venues', $_SESSION['ROLE'], 'AND dateReserver = "'.date('Y-m-d').'"'),
				'VenuesNumPersDayYes' => $Reservers->row('SUM(idReserver) as numPerson', 'venues', $_SESSION['ROLE'], 'AND dateReserver = "'.date('Y-m-d', strtotime('-1 day')).'"'),
				'Venuestype1DayNow' => $Reservers->row('COUNT(idReserver) as numType', 'venues', $_SESSION['ROLE'], 'AND typeReserver = 1 AND dateReserver = "'.date('Y-m-d').'"'),
				'Venuestype2DayNow' => $Reservers->row('COUNT(idReserver) as numType', 'venues', $_SESSION['ROLE'], 'AND typeReserver = 2 AND dateReserver = "'.date('Y-m-d').'"'),
			));	
		}else{
			$this->render('sign/in.twig');
		}		
	}
}
