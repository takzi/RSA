<?php
/**
 * @auth Anthony Perez
 * @date 09/24/17
 **/

class Availability{

	private $bus_driver_ID, $availability, $time_of_day;

	// Get the bus driver's id that is associated with the availabilty
	public function getBusDriverID(){return $this->bus_driver_ID;}
	// Get the bus driver's availability
	public function getAvailability(){return $this->availability;}
	// Get the bus driver's preferred time of day
	public function getTimeOfDay(){return $this->time_of_day;}
}
