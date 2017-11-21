<?php
/**
 * @auth Anthony Perez
 * @date 09/11/17
 *
 * A class of a User's information
 **/

class User{

	private $id, $first_name, $last_name, $role_ID, $email, $password;

	// Get the id of the User
	public function getID(){return $this->id;}
	// Get the User's first name
	public function getFirstName(){return $this->first_name;}
	// Get the User's last name
	public function getLastName(){return $this->last_name;}
	// Get the User's whole name
	public function getWholeName(){return $this->first_name." ".$this->last_name;}
	// Get the User's email
	public function getEmail(){return $this->email;}
	// Get the User's password
	public function getPassword(){return $this->password;}
	// Get the User's current role in the RAHIN system
	public function getRole(){return $this->role_ID;}
}
