<?php
/**
 * @auth Anthony Perez
 * @date 09/11/17
 **/

class Congregation{

	private $id, $contact_ID, $name;

	// Get the congregation id
	public function getID(){return $this->id;}
	// Get the leader's id
	public function getContactID(){return $this->contact_ID;}
	// Get the name of the congregation
	public function getName(){return $this->name;}
}
