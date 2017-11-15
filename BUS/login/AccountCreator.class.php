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

	function createNewAccount($_fname, $_lname, $_role, $_email, $_pass, $_confirmpass, $_contactNum="",$_congName=""){
		$sanitizerResult = $this->sanitizeValidateData($_fname, $_lname, $_role, $_email, $_pass, $_confirmpass);

		if($sanitizerResult != "Clear"){
			return $sanitizerResult;
		}

		if($_role != -1){
			// Checking to make sure the email is not already used
			if($this->checkUniqueEmail($_email)){	
					if($_pass === $_confirmpass){			
					// Create new account
					$uid = $this->db->insertNewUser($_fname, $_lname, $_role, $_email, $_pass);
					switch ($_role) {
						case 4:
							$this->db->insertNewCongregation($uid,$_congName);
							break;
						
						case 5:
							$this->db->insertNewBusDriver($uid,$_contactNum);
							break;

						default:
							break;
					}
					return "Account created";	
					}
					return "Password are not matched.";			
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

	function sanitizeValidateData($fname, $lname, $role, $email, $pass, $confirmpass){
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

		if(!$this->sanitizer->sanitizeString($confirmpass)){
			return "Invalid characters used in Confirm Password";
		}

		return "Clear";
	}
}


?>