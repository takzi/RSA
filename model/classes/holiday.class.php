<?php
/**
 * @auth Anthony Perez
 * @date 09/24/17
 **/

class Holiday{

	private $name, $date, $last_congregation;

	// Get the name of the current holiday
	public function getName(){return $this->name;}
	// Get the date of the holiday
	public function getDate(){return $this->date;}
	// Get the recent congregation who had this holiday
	public function getLastCongregation(){return $this->last_congregation;}
}
