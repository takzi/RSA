<?php

class AccountCreator{
	private $path_to_root;
	private $db;
	private $sanitizer;

	public function __construct($path_to_root){
		$this->path_to_root = $path_to_root;

		require_once($this->path_to_root.'../model/DB.class.php');
		$this->db = new DB($this->path_to_root);

		require_once($this->path_to_root.'../BUS/Sanitizer.class.php');
		$this->sanitizer = new Sanitizer();
	}

	function createNewAccount($_fname, $_lname, $_role, $_email, $_pass){
		$sanitizerResult = $this->sanitizeValidateData($_fname, $_lname, $_role, $_email, $_pass);

		if($sanitizerResult != "Clear"){
			return $sanitizerResult;
		}

		if($_role != "default"){
			// Checking to make sure the email is not already used
			if($this->checkUniqueEmail($_email)){
				$roleId = -1;

				$roleId = $this->getRoleId($_role);
				
				if($roleId != -1){
					// Create new account
					//$this->db->insertNewUser($_fname, $_lname, $roleId, $_email, $_pass);

					// redirect upon success
					return "Account created";
				} else {
					return "Invalid role selected.";
				}				
			} else {
				return "Email already in use.";
			}
		} else {
			return "Please select a role.";
		}	
		
	}

	function checkUniqueEmail($_email){
		$users = $this->db->getUserByEmail($_email);

		if(count($users) > 0){
			return false;
		}

		return true;
	}

	function sanitizeValidateData($fname, $lname, $role, $email, $pass){
		if(!$this->sanitizer->sanitizeEmail($email)){
			return "Invalid characters used in email.";
		}
		
		if(!$this->sanitizer->validateEmail($email)){
			return "Invalid email provided.";
		}

		if(!$this->sanitizer->sanitizeString($fname)){
			return "Invalid characters used in First Name.";
		}

		if(!$this->sanitizer->sanitizeString($lname)){
			return "Invalid cahracters used in Last Name";
		}

		if(!$this->sanitizer->sanitizeString($role)){
			return "Invalid characters used in Role";
		}

		if(!$this->sanitizer->sanitizeString($pass)){
			return "Invalid characters used in Password";
		}

		return "Clear";
	}

	function getRoleId($roleName){
		switch($roleName){
			case "admin": return 0; 
			case "bus_driver": return 2; 
			case "congregation": return 3; 
		}
		return -1;
	}
}


?>