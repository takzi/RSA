<?php
/**
 * LoginChecker holds the functionality to check
 * a login attempt on the RSA site.
 *
 *
 * @author     Kristen Merritt
 * @author     Anthony Perez
 * @version    Release: 1.0
 * @date       11/15/2017
 */

class LoginChecker {
	private $db;        // the database object
	private $id;        // id of the user logging in
	private $firstName; // first name of the user logging in
	private $lastName;  // last name of the user logging in
	private $email;     // email of the user logging in
	private $password;  // password of the user logging in
	private $role;      // role id of the user logging in

	/**
	 * Constructor of the LoginChecker object,
	 * initializes the db object.
	 * 
	 * @param string $path_to_root path to public_html root
	 */
	public function __construct($path_to_root){
		require_once($path_to_root.'../model/DB.class.php');
		$this->db = new DB($path_to_root);
	}

	/**
	 * Checks the login credentials of the user.
	 * 
	 * @param  string $_email    email used in login attempt
	 * @param  string $_password password used in login attempt
	 * @return boolean           true if successful login
	 */
	function attemptLogin($_email, $_password){
		$userExists = $this->checkForUser($_email);

		if($userExists){
			if(password_verify($_password, $this->password)){
				return true;
			}
		}

		return false;
	}

	/**
	 * Checks to see if a user exists based on
	 * email provided.
	 * 
	 * @param  string $_email email used in login
	 * @return boolean        true if user exists
	 */
	function checkForUser($_email){
		$users = $this->db->getUserByEmail($_email);

		if(count($users) == 0){
			return false;
		} 

		$user = $users[0];
		$this->id = $user->getId();
		$this->firstName = $user->getFirstName();
		$this->lastName = $user->getLastName();
		$this->email = $user->getEmail();
		$this->password = $user->getPassword();
		$this->role = $user->getRole();

		return true;
	}

	/**
	 * Returns the user ID of the
	 * user found matching the login
	 * credentials.
	 * 
	 * @return int id
	 */
	function getUserId(){
		return $this->id;
	}

	/**
	 * Returns the first name of the 
	 * user found matching the login 
	 * credentials.
	 * 
	 * @return string first name
	 */
	function getFirstName(){
		return $this->firstName;
	}

	/**
	 * Returns the last name of the
	 * user found matching the login 
	 * credentials.
	 * 
	 * @return string last name
	 */
	function getLastName(){
		return $this->lastName;
	}

	/**
	 * Returns the email of the 
	 * user found matching the login
	 * credentials
	 * 
	 * @return string email
	 */
	function getEmail(){
		return $this->email;
	}

	/**
	 * Returns the password of the
	 * user found matching the login
	 * credentials.
	 * 
	 * @return string password
	 */
	function getPassword(){
		return $this->password;
	}

	/**
	 * Returns the role id of the
	 * user found matching hte login
	 * credentials.
	 * 
	 * @return int role id
	 */
	function getRole(){
		return $this->role;
	}

}

?>