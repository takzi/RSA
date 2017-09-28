<?php
/**
 * @auth Anthony Perez
 * @date 09/11/17
 **/

class User{

	private $id, $first_name, $last_name, $role_ID, $email, $password;

	public function getID(){return $this->id;}
	public function getFirstName(){return $this->first_name;}
	public function getLastName(){return $this->last_name;}
	public function getWholeName(){return $this->first_name." ".$this->last_name;}
	public function getEmail(){return $this->email;}
	public function getPassword(){return $this->password;}
	public function getRole(){return $this->role_ID;}
}
