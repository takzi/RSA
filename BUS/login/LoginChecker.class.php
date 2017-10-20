<?php

class LoginChecker(){
	private $db;

	private $id;
	private $firstName;
	private $lastName;
	private $email;
	private $password;
	private $role;

	public __construct($path_to_root){
		require_once($path_to_root.'../models/DB.class.php');
		$this->db = new DB($path_to_root);
	}


	function attemptLogin($_email, $_password){
		$userExists = $this->checkForUser($_email);

		if($userExists){
			if(password_verify($password, $this->password)){
				return true;
			}
		}

		return false;
	}

	function checkForUser($_email){
		$users = $this->db->getUserByEmail($_email);

		if(count($users) == 0){
			return false;
		} 

		$user = $users[0];
		$this->$id = $user->getId();
		$this->$firstName = $user->getFirstName();
		$this->$lastName = $user->getLastName();
		$this->$email = $user->getEmail();
		$this->$password = $user->getPassword();
		$this->$role = $user->getRole();

		return true;
	}

	function getUserId(){
		return $this->id;
	}

	function getFirstName(){
		return $this->firstName;
	}

	function getLastName(){
		return $this->lastName;
	}

	function getEmail(){
		return $this->email;
	}

	function getPassword(){
		return $this->password;
	}

	function getRole(){
		return $this->role;
	}

}

?>