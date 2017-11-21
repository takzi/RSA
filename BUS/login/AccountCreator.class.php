<?php
/**
 * AccountCreator holds all of the functionality
 * to create a new account in the RSA database.
 *
 *
 * @author     Kristen Merritt
 * @author     Tiandre Turner
 * @author     Anthony Perez
 * @version    Release: 1.0
 * @date       11/15/2017
 */

class AccountCreator{
	private $path_to_root; // provide the location of the root of public_html
	private $db;		   // the database object
	private $sanitizer;    // sanitizer object that holds sanitization functionality

	/**
	 * Constructor for the AccountCreator object.
	 * Initializes the database and the root path.
	 * 
	 * @param string $path_to_root [path to the public_html root]
	 */
	public function __construct($path_to_root){
		$this->path_to_root = $path_to_root;

		require_once($this->path_to_root.'../model/DB.class.php');
		$this->db = new DB($this->path_to_root);

		require_once($this->path_to_root.'../BUS/Sanitizer.class.php');
		$this->sanitizer = new Sanitizer();
	}

	/**
	 * Creates a new account in the database.
	 * 
	 * @param  string $_fname       first name
	 * @param  string $_lname       last name
	 * @param  int    $_role        role id
	 * @param  string $_email       email of the user
	 * @param  string $_pass        password
	 * @param  string $_confirmpass confirmed password
	 * @param  string $_contactNum  contact number
	 * @param  string $_congName    congregation name
	 * @return string               message about account
	 */
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
						case 4: // congregation account
							$this->db->insertNewCongregation($uid,$_congName);
							break;
						
						case 5: // bus driver account
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

	/**
	 * Checks to make sure the email provided is not
	 * already in use.
	 * 		
	 * @param  string $_email email provided			
	 * @return boolean        true if unique email
	 */
	function checkUniqueEmail($_email){
		$users = $this->db->getUserByEmail($_email);

		if(count($users) > 0){
			return false;
		}

		return true;
	}

	/**
	 * Sanitizes the data intended to be used in the
	 * creation of an account.
	 * 
	 * @param  string $fname       first name
	 * @param  string $lname       last name
	 * @param  int $role           role id
	 * @param  string $email       email
	 * @param  string $pass        password
	 * @param  string $confirmpass confirmed password
	 * @return string              "Clear" if everything is good
	 */
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