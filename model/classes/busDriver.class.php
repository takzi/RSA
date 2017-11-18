<?php
/**
 * @auth Anthony Perez
 * @date 09/11/17
 **/

class BusDriver{

	private $id, $contact_ID, $contact_number;

	// Get the bus driver's id
	public function getID(){return $this->id;}
	// Get the bus driver's contact id which is associated with the user's id
	public function getContactID(){return $this->contact_ID;}
	// Get the bus driver's contact number
	public function getContactNumber(){return $this->contact_number;}
}
