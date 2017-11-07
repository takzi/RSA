<?php
/**
 * Class DB.class.php
 * @auth Anthony Perez
 * @date 09/11/17
 **/
 class DB{
 	function __construct($path_to_root){
 		require_once("classes/availability.class.php");
 		require_once("classes/blackoutDates.class.php");
 		require_once("classes/busDriver.class.php");
		require_once("classes/congregation.class.php");
		require_once("classes/holiday.class.php");
		require_once("classes/role.class.php");
		require_once("classes/rotation.class.php");
		require_once("classes/supportingCongregation.class.php");
		require_once("classes/user.class.php");
		require_once("classes/schedule.class.php");

		require_once($path_to_root."../dbInfo.php");

		try{
			//initiate PDO connection to the database
			$this->db = new PDO("mysql:host=$host;dbname=$db",$user,$pass);
			//change error reporting
			$this->db->setAttribute(PDO::ATTR_ERRMODE,
									PDO::ERRMODE_EXCEPTION);
		}
		catch(PDOException $e){
			echo $e->getMessage();
			die();
		}
 	}

 	// USER ===================================================================

 	/**
 	 *  getAllUsers - will return all current existing users in the user table.
 	 *  
 	 * @return user $data - user objects to return
 	 */
 	public function getAllUsers(){
 		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM user");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'user');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllUsers - ".$e->getMessage();
			die();
		}
		return $data;
	}
	/**
	 *  getUser - will return user that currently exist in the users table and 
	 * matches the provided id.
	 * 
	 * @param  int $_id - user id to match.
	 * @return user $data - user object to return.
	 */
	public function getUser($_id){
		try{
			$stmt = $this->db->prepare("SELECT
										u.id AS 'id',
										u.first_name AS 'first_name',
										u.last_name AS 'last_name',
										u.role_ID AS 'role_ID',
										u.email AS 'email',
										u.password AS 'password',
										r.name AS 'role'
										FROM user u
										JOIN role r ON u.role_ID = r.id
										WHERE u.id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'user');

			return $data;
		}
		catch(PDOException $e){
			echo "getUser - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	getUserFullName - will return full name ('firstName' 'lastName') for a
	 * user that currently exist in the user table and matches the provided id.
	 *
	 * @param  int $_id - user id to match.
	 * @return array $data - array containing the desired user's full name.
	 **/
	function getUserFullName($_id){
		try{
			$stmt = $this->db->prepare("SELECT
										 CONCAT(first_name,' ',last_name)
										 AS 'Full Name'
										FROM user
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getUserFullName - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	getUserRole - will return the role id  for a user that currently exist
	 * in the user table and matches the provided id.
	 *
	 * @param  int $_id - user id to match.
	 * @return int $data - integer representing the desired user's role id.
	 **/
	function getUserRole($_id){
		try{
			$stmt = $this->db->prepare("SELECT role_ID
										FROM user
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getUserRole - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	getUserByEmail - will return a user object for a user that currently 
	 * exist in the user table and matches the provided email.
	 *
	 * @param  int $_id - user id to match.
	 * @return int $data - integer representing the desired user's role id.
	 **/
	function getUserByEmail($_email){
		try{
			$stmt = $this->db->prepare("SELECT *
										FROM user
										WHERE email = :email");
			$stmt->bindParam(":email",$_email,PDO::PARAM_STR);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'user');

			return $data;
		}
		catch(PDOException $e){
			echo "getUserByEmail - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	getUserEmail - will return the email for a user that currently exist in
	 * the user table and matches the provided id.
	 *
	 * @param  int $_id - user id to match.
	 * @return string $data - string representing the desired user's email.
	 **/
	function getUserEmail($_id){
		try{
			$stmt = $this->db->prepare("SELECT email
										FROM user
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getUserEmail - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	insertNewUser - will insert a new record to the user table with the 
	 * provided information.
	 *
	 * @param string $_firstName - firstName of the user to add.
	 * @param string $_lastName - lastName of the user to add.
	 * @param integer $_roleID - roleid of the user to add.
	 * @param string $_email - email of the user to add.
	 * @param string $_password - pasword of the user to add.
	 * @return integer containing the id of the newest user added.
	 **/
	function insertNewUser($_firstName, $_lastName, $_roleID,$_email, 
														$_password){
		$password = password_hash($_password, PASSWORD_DEFAULT);
		try{
			$stmt = $this->db->prepare("INSERT INTO user 
								(first_name,last_name,role_ID,email,password)
				VALUES (:first_name,:last_name,:role_ID,:email,:password)");
			$stmt->bindParam(":first_name",$_firstName,PDO::PARAM_STR);
			$stmt->bindParam(":last_name",$_lastName,PDO::PARAM_STR);
			$stmt->bindParam(":email",$_email,PDO::PARAM_STR);
			$stmt->bindParam(":password",$password,PDO::PARAM_STR);
			$stmt->bindParam(":role_ID",$_roleID,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewUser - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	updateUser - will update a record from the user table with the 
	 * provided information.
	 *
	 * @param integer $_uid - uid for the user to update.
	 * @param string $_fName - firstName of the user to update.
	 * @param string $_lName - lastName of the user to update.
	 * @param integer $_roleID - roleid of the user to update.
	 * @param string $_email - email of the user to update.
	 * @param string $_password - pasword of the user to update.
	 * @return integer containing the id of the newest user updated.
	 **/
	function updateUser($_id, $_firstName, $_lastName, $_roleID, $_email,
															 $_password){
		$password = password_hash($_password, PASSWORD_DEFAULT);
		try{
			$stmt = $this->db->prepare("UPDATE user 
			SET first_name=:first_name,last_name=:last_name,email=:email,
			password=:password,role_ID=:role_ID
			WHERE id=:id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->bindParam(":first_name",$_firstName,PDO::PARAM_STR);
			$stmt->bindParam(":last_name",$_lastName,PDO::PARAM_STR);
			$stmt->bindParam(":email",$_email,PDO::PARAM_STR);
			$stmt->bindParam(":password",$password,PDO::PARAM_STR);
			$stmt->bindParam(":role_ID",$_roleID,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "updateUser - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	deleteUser - will delete a record from the user table that matches the
	 * provided user id.
	 *
	 * @param integer $_id - user uid to match.
	 * @return integer containing the id of the affected user.
	 **/
	function deleteUser($_id){
		try{
			$stmt = $this->db->prepare("DELETE FROM user WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "deleteUser - ".$e->getMessage();
			die();
		}
	}

	// ROLE ===================================================================

	/**
	 *	getAllRoles - will return all roles that currently exist in the
	 * role table.
	 *
	 * @return role $data - role objects to return.
	 **/
	function getAllRoles(){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM role");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'role');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllRoles - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getRole - will return the role that currently exist in the
	 * role table and that matches the provided id.
	 *
	 * @param integer $_id - if of the role to match.
	 * @return role $data - role object to return.
	 **/
	function getRole($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM role 
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'role');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllUsers - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getRoleID - will return the id of the role that currently exist in the
	 * role table and matches the provided name.
	 *
	 * @param string $_name - name of the role to match.
	 * @return string $data - name of the role object to return.
	 **/
	function getRoleID($_name){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT id 
										FROM role 
										WHERE name = :name");
			$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getRoleID - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getRoleName - will return the name of the role that currently exist in 
	 * the role table and matches the provided id.
	 *
	 * @param integer $_id - id of the role to match.
	 * @return string $data - name of the role object to return.
	 **/
	function getRoleName($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT name 
										FROM role 
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getRoleName - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 * 	insertNewRole - will insert a new record to the role table with the 
	 * provided information.
	 *
	 * @param string $_name - name of the role to add.
	 * @return integer containing the id of the newest role added.
	 **/
	function insertNewRole($_name){
		try{
			$stmt = $this->db->prepare("INSERT INTO role (name) VALUES (:name)");
			$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewRole - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	updateRole - will update a record in the role table with the 
	 * provided information.
	 *
	 * @param integer $_id - id of the role to update.
	 * @param string $_name - name of the role to update.
	 * @return integer containing the id of the newest role added.
	 **/
	function updateRole($_id, $_name){
		try{
			$stmt = $this->db->prepare("UPDATE role SET name=:name WHERE id=:id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "updateRole - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	deleteRole - will delete a record from the role table that matches the
	 * provided role id.
	 *
	 * @param integer $_id - role id to match.
	 * @return integer containing the id of the erased role.
	 **/
	function deleteRole($_id){
		try{
			$stmt = $this->db->prepare("DELETE FROM role WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "deleteRole - ".$e->getMessage();
			die();
		}
	}

	// CONGREGATION ===========================================================
	
	/**
	 *	getAllCongregations - will return all congregations that currently
	 * exist in the congregation table.
	 *
	 * @return congregation $data - congregation objects to return.
	 **/
	function getAllCongregations(){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM congregation");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'congregation');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllCongregations - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getCongregation - will return the congregation that currently
	 * exist in the congregation table and matches the provided id.
	 *
	 * @param integer $_id - congregation id to match.
	 * @return congregation $data - congregation object to return.
	 **/
	function getCongregation($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM congregation 
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'congregation');

			return $data;
		}
		catch(PDOException $e){
			echo "getCongregation - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getCongregationID - will return the id for the congregation 
	 * that currently exist in the congregation table and matches 
	 * the provided name.
	 *
	 * @param string $_name - congregation name to match.
	 * @return integer $data - congregation id to return.
	 **/
	function getCongregationID($_name){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT id 
										FROM congregation 
										WHERE name = :name");
			$stmt->bindParam(":name",$_name,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getCongregationID - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getCongregationName - will return the name for the congregation that
	 * currently exist in the congregation table and matches the provided id.
	 *
	 * @param integer $_id - congregation id to match.
	 * @return string $data - congregation id to return.
	 **/
	function getCongregationName($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT name 
										FROM congregation 
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getCongregationName - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getCongregationContactID - will return the id for the congregation
	 * contact that currently exist in the congregation table and matches 
	 * the provided congregation id.
	 *
	 * @param integer $_id - congregation id to match.
	 * @return integer $data - congregation contact id to return.
	 **/
	function getCongregationContactID($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT contact_ID 
										FROM congregation 
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getCongregationContactID - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 * 	insertNewCongregation - will insert a new record to the congregation
	 * table with the provided information.
	 *
	 * @param integer $_contactID - id of the user who is the point of
	 *                            	contact of the congregation to add.
	 * @param string $_name - name of the congregation to add.
	 * @return integer containing the id of the newest role added.
	 **/
	function insertNewCongregation($_contactID, $_name){
		try{
			$stmt = $this->db->prepare("INSERT INTO congregation 
										(contact_ID, name) 
										VALUES (:contact_ID, :name)");
			$stmt->bindParam(":contact_ID",$_contactID,PDO::PARAM_STR);
			$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewCongregation - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	updateCongregation - will update a record in the congregation table with the 
	 * provided information.
	 *
	 * @param integer $_id - congregation id to match.
	 * @param integer $_contactID - congregation id to update.
	 * @param string $_name - congregation name to update.
	 * @return integer $data - congregation contact id to return.
	 **/
	function updateCongregation($_id, $_contactID, $_name){
		try{
			$stmt = $this->db->prepare("UPDATE congregation 
						SET contact_ID=:contact_ID,name=:name WHERE id=:id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->bindParam(":contact_ID",$_contactID,PDO::PARAM_INT);
			$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "updateCongregation - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	deleteCongregation - will delete a record from the congregation table
	 * that matches the provided congregation id.
	 *
	 * @param integer $_id - congregation id to match.
	 * @return integer containing the id of the erased congregation.
	 **/
	function deleteCongregation($_id){
		try{
			$stmt = $this->db->prepare("DELETE FROM congregation WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "deleteRole - ".$e->getMessage();
			die();
		}
	}

	// BUS DRIVER =============================================================
	
	/**
	 *	getAllBusDrivers - will return all bus drivers that currently exist in
	 * the bus_driver table.
	 *
	 * @return busDriver $data - busDriver objects to return.
	 **/
	function getAllBusDrivers(){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM bus_driver");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'busDriver');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllBusDrivers - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getBusDriver - will return the bus drivers that currently exist in
	 * the bus_driver table and matches the provided id.
	 *
	 * @param integer $_id - bus driver id to match.
	 * @return busDriver $data - busDriver object to return.
	 **/
	function getBusDriver($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM bus_driver 
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'busDriver');

			return $data;
		}
		catch(PDOException $e){
			echo "getBusDriver - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getBusDriverContactID - will return the contact id of the bus 
	 * driver that currently exist in the bus_driver table and 
	 * matches the provided id.
	 * 
	 * @param integer $_id - bus driver id to match.
	 * @return integer $data - busDriver contact id to return.
	 **/
	function getBusDriverContactID($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT contact_ID 
										FROM bus_driver 
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getBusDriverContactID - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getBusDriverContactNumber - will return the contact number of the bus
	 * driver that currently exist in the bus_driver table and matches the 
	 * provided id.
	 *
	 * @param integer $_id - bus driver id to match.
	 * @return integer $data - busDriver contact id to return.
	 **/
	function getBusDriverContactNumber($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT contact_number 
										FROM bus_driver 
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getBusDriverContactNumber - ".$e->getMessage();
			die();
		}
		return $data;
	}
	
	/**
	 * 	insertNewBusDriver - will insert a new record to the bus_driver table
	 * with the provided information.
	 *
	 * @param integer $_contactID - user id who is the bus driver to add.
	 * @param string $_contactNumber - phone number of the bus driver to add.
	 * @return integer containing the id of the newest bus driver added.
	 **/
	function insertNewBusDriver($_contactID, $_contactNumber){
		try{
			$stmt = $this->db->prepare("INSERT INTO bus_driver 
										(contact_ID, contact_number) 
										VALUES (:contact_ID,:contact_number)");
			$stmt->bindParam(":contact_ID",$_contactID,PDO::PARAM_STR);
			$stmt->bindParam(":contact_number",$_contactNumber,PDO::PARAM_STR);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewCongregation - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	updateBusDriver - will update a record in the bus_driver table with the 
	 * provided information.
	 *
	 * @param integer $_id - bus driver id to match.
	 * @param integer $_contactID - bus driver contact id to update.
	 * @param string $_contactNumber - bus driver contact number to update.
	 * @return integer $data - congregation contact id to return.
	 **/
	function updateBusDriver($_id, $_contactID, $_contactNumber){
		try{
			$stmt = $this->db->prepare("UPDATE bus_driver 
				SET contact_ID=:contact_ID,contact_number=:contact_number
				WHERE id=:id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->bindParam(":contact_ID",$_contactID,PDO::PARAM_INT);
			$stmt->bindParam(":contact_number",$_contactNumber,PDO::PARAM_STR);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "updateBusDriver - ".$e->getMessage();
			die();
		}
	}
	/**
	 * 	deleteBusDriver - will delete a record from the bus_driver table that matches
	 * the provided bus driver id.
	 *
	 * @param integer $_id - bus driver id to match.
	 * @return integer containing the id of the affected bus driver.
	 **/
	function deleteBusDriver($_id){
		try{
			$stmt = $this->db->prepare("DELETE FROM bus_driver WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "deleteRole - ".$e->getMessage();
			die();
		}
	}

	// HOLIDAYS ===============================================================
	
	/**
	 *	getAllHolidays - will return all holidays that currently exist in the
	 * holidays table.
	 *
	 * @return holiday $data - holiday objects to return.
	 **/
	function getAllHolidays(){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM holidays");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'holiday');
			var_dump("data()");
			var_dump($data);
			return $data;
		}
		catch(PDOException $e){
			echo "getAllHolidays - ".$e->getMessage();
			die();
		}

		return $data;
	}

	/**
	 *	getHoliday - will return the holiday that currently exist in the
	 * holidays table and matches the provided holiday name and date.
	 *
	 * @param string $_name - holiday name to match.
	 * @param string $_date - holiday date to match.
	 * @return holiday $data - holiday object to return.
	 **/
	function getHoliday($_name, $_date){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM holidays h
										WHERE name = :name
										AND h.date = :date");
			$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
			$stmt->bindParam(":date",$_date,PDO::PARAM_STR);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'holiday');

			return $data;
		}
		catch(PDOException $e){
			echo "getHoliday - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getHolidayName - will return the holiday name that currently exist in
	 * the holidays table and matches the provided date.
	 *
	 * @param string $_date - holiday date to match.
	 * @return string $data - holiday name to return.
	 **/
	function getHolidayName($_date){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT name 
										FROM holidays h
										WHERE h.date = :date");
			$stmt->bindParam(":date",$_date,PDO::PARAM_STR);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getHolidayName - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getHolidayDates - will return the holiday date that currently exist in
	 * the holidays table and matches the provided name.
	 *
	 * @param string $_date - holiday date to match.
	 * @return string $data - holiday name to return.
	 **/
	function getHolidayDates($_name){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT h.date AS 'date' 
										FROM holidays h
										WHERE name = :name");
			$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getHolidayDates - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	getHolidayDatesForCongregation - will return the holiday dates that
	 * currently exist in the holidays table and matches the provided
	 * congregation id.
	 *
	 * @param string $_date - holiday date to match.
	 * @return string $data - holiday name to return.
	 **/
	function getHolidayDatesForCongregation($_congregation){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT h.date AS 'date' 
										FROM holidays h
										WHERE last_congregation = :congregation");
			$stmt->bindParam(":congregation",$_congregation,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getHolidayName - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 * 	insertNewHoliday - will insert a new record to the holidays table
	 * with the provided information.
	 *
	 * @param string $_name - name of the holiday to add.
	 * @param string $_date - date of the holiday to add.
	 * @param integer $_congregation - congregation who was 
	 *                               assigned the holiday.
	 * @return integer containing the id of the newest holiday added.
	 **/
	function insertNewHoliday($_name, $_date, $_congregation=""){
		try{
			if($_congregation != ""){
				$stmt = $this->db->prepare("INSERT INTO holidays h
										(name, h.date) 
										VALUES (:name,:date)");
				$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
				$stmt->bindParam(":date",$_date,PDO::PARAM_STR);
			}
			else{
				$stmt = $this->db->prepare("INSERT INTO holidays h
										(name, h.date, last_congregation) 
										VALUES (:name,:date,:congregation)");
				$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
				$stmt->bindParam(":date",$_date,PDO::PARAM_STR);
				$stmt->bindParam(":congregation",$_congregation,PDO::PARAM_STR);
			}
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewCongregation - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	updateHoliday - will update a record in the holiday table with the 
	 * provided information.
	 *
	 * @param string $_name - holiday name to match and update.
	 * @param string $_date - holiday date to match and update.
	 * @param integer $_congregation - holiday congregation to update.
	 * @return integer $data - congregation contact id to return.
	 **/
	function updateHoliday($_name, $_date, $_congregation){
		try{
			if($_congregation != ""){
				$stmt = $this->db->prepare("UPDATE holidays h
				SET name=:name,
				h.date=:date,
				last_congregation:congregation
				WHERE name=:name AND h.date=:date");

				$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
				$stmt->bindParam(":date",$_date,PDO::PARAM_STR);
				$stmt->bindParam(":congregation",$_congregation,PDO::PARAM_STR);
			}
			else{
				$stmt = $this->db->prepare("UPDATE holidays h
				SET name=:name,h.date=:date 
				WHERE name=:name AND h.date=:date");
				$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
				$stmt->bindParam(":date",$_date,PDO::PARAM_STR);
				$stmt->bindParam(":congregation",$_congregation,PDO::PARAM_STR);
			}
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "updateHoliday - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	deleteHoliday - will delete a record from the holidays table that 
	 * matches the provided holiday name and date.
	 *
	 * @param string $_name - holiday name to match.
	 * @param string $_date - holiday date to match.
	 * @return integer containing the id of the affected holiday.
	 **/
	function deleteHoliday($_name, $_date){
		try{
			$stmt = $this->db->prepare("DELETE FROM holidays
										WHERE name=:name AND h.date=:date");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "deleteRole - ".$e->getMessage();
			die();
		}
	}

	// BLACKOUT DATES =========================================================
	
	/**
	 *  getAllBlackoutDates - will return all blackout
	 * dates that currently exist in the blackout_dates table.
	 *
	 * @return blackoutDates $data - blackoutDates objects to return.
	 **/
	function getAllBlackoutDates(){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM blackout_dates");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'blackoutDates');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllHolidays - ".$e->getMessage();
			die();
		}
		return $data;
	}

	function getBlackoutdatesForCongregation($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT blackout_date_from,
												blackout_date_to
										FROM blackout_dates
										WHERE congregation_ID = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'blackoutDates');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllHolidays - ".$e->getMessage();
			die();
		}
		return $data;
	}

	function getBlackoutdatesForCongregationFrom($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT blackout_date_from
										FROM blackout_dates
										WHERE congregation_ID = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'blackoutDates');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllHolidays - ".$e->getMessage();
			die();
		}
		return $data;
	}

	function getBlackoutdatesForCongregationTo($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT blackout_date_to
										FROM blackout_dates
										WHERE congregation_ID = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'blackoutDates');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllHolidays - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 * 	insertNewBlackoutdate - will insert a new record to the blackout_dates 
	 * table with the provided information.
	 *
	 * @param integer $_congregationID - id of the congregation whose blackout 
	 *                                 date we are to add.
	 * @param string $_blackoutDateFrom - start of the blackout date to add.
	 * @param string $_blackoutDateTo - end of the blackout date to add.
	 * @return integer containing the id of the newest blackout date added.
	 **/
	function insertNewBlackoutdate($_congregationID,$_blackoutDateFrom,$_blackoutDateTo){
		try{
			$stmt = $this->db->prepare("INSERT INTO blackout_dates  
			VALUES (:congregation_ID,:blackout_date_from,:blackout_date_to)");
			$stmt->bindParam(":congregation_ID",$_congregationID,PDO::PARAM_INT);
			$stmt->bindParam(":blackout_date_from",$_blackoutDateFrom,PDO::PARAM_STR);
			$stmt->bindParam(":blackout_date_to",$_blackoutDateTo,PDO::PARAM_STR);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewBlackoutdate - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	updateBlackoutdate - will update a record in the blackout_dates table
	 * with the provided information.
	 *
	 * @param string $_congregationID - congregation id to match.
	 * @param string $_blackoutDateTo - start blackout date to match 
	 *                                	and update.
	 * @param integer $_blackoutDateFrom - end blackout date to match
	 *                                     and update.
	 * @return integer $data - blackout date id to return.
	 **/
	function updateBlackoutdate($_congregationID,$_blackoutDateTo,$_blackoutDateFrom){
		try{
			$stmt = $this->db->prepare("UPDATE blackout_dates 
				SET blackout_date_from=:blackout_date_from,
					blackout_date_to=:blackout_date_to
				WHERE congregation_ID=:congregation_ID");
			$stmt->bindParam(":congregation_ID",$_congregationID,PDO::PARAM_INT);
			$stmt->bindParam(":blackout_date_from",$_blackoutDateFrom,PDO::PARAM_STR);
			$stmt->bindParam(":blackout_date_to",$_blackoutDateTo,PDO::PARAM_STR);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "updateBusDriver - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	deleteBlackoutdate - will delete a record from the blackout_dates table 
	 * that matches the provided blackout date's congregationID,
	 * blackout_date_From, blackout_date_to.
	 *
	 * @param string $_congregationID - blackout date congregation to match.
	 * @param string $_blackoutDateFrom - blackout date start date to match.
	 * @param string $_blackoutDateTo - blackout date end date to match.
	 * @return integer containing the id of the affected blackout date.
	 **/
	function deleteBlackoutdate($_congregationID,$_blackoutDateTo,$_blackoutDateFrom){
		try{
			$stmt = $this->db->prepare("DELETE FROM blackout_dates 
					WHERE congregation_ID=:congregation_ID 
					AND blackout_date_from=:blackout_date_from
					AND blackout_date_to=:blackout_date_to");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "deleteRole - ".$e->getMessage();
			die();
		}
	}

	// ROTATIONS ==============================================================
	
	/**
	 *  getAllRotations - will return all rotations
	 * that currently exist in the rotation table.
	 *
	 * @return rotation $data - rotation objects to return.
	 **/
	function getAllRotations(){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * FROM rotation");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'rotation');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllRotations - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *  getRotation - will return the rotation that currently exist in the
	 * rotation table and matches the rotation id.
	 *
	 * @param integer $_id - id of rotation to match. 
	 * @return rotation $data - rotation object to return.
	 **/
	function getRotation($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM rotation
										WHERE id = :id");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'blackoutDates');

			return $data;
		}
		catch(PDOException $e){
			echo "getRotationNumber - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 * 	insertNewRotation - will insert a new record to the rotation 
	 * table with the provided information.
	 *
	 * @param integer $_congregationID - id of the congregation whose blackout 
	 *                                 date we are to add.
	 * @param string $_blackoutDateFrom - start of the blackout date to add.
	 * @param string $_blackoutDateTo - end of the blackout date to add.
	 * @return integer containing the id of the newest blackout date added.
	 **/
	function insertNewRotation($_rotationID,$_rotationNumber,
		$_congregationID,$_rotationDateFrom,$_rotationDateTo){
		try{
			$stmt = $this->db->prepare("INSERT INTO rotation  
			VALUES (:rotationID,:rotation_number,:congregation_ID,
					:rotation_date_from,:rotation_date_to)");
			$stmt->bindParam(":rotationID",$_rotationID,PDO::PARAM_INT);
			$stmt->bindParam(":rotation_number",$_rotationNumber,PDO::PARAM_INT);
			$stmt->bindParam(":congregation_ID",$_congregationID,PDO::PARAM_INT);
			$stmt->bindParam(":rotation_date_from",$_rotationDateFrom,PDO::PARAM_STR);
			$stmt->bindParam(":rotation_date_to",$_rotationDateTo,PDO::PARAM_STR);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewRotation - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	updateBlackoutdate - will update a record in the blackout_dates table
	 * with the provided information.
	 *
	 * @param string $_congregationID - congregation id to match.
	 * @param string $_blackoutDateTo - start blackout date to match 
	 *                                	and update.
	 * @param integer $_blackoutDateFrom - end blackout date to match
	 *                                     and update.
	 * @return integer $data - blackout date id to return.
	 **/
	function updateRotation($_rotationID,$_rotationNumber,
		$_congregationID,$_rotationDateFrom,$_rotationDateTo){
		try{
			$stmt = $this->db->prepare("UPDATE rotation  
				SET rotation_date_from=:rotation_date_from,
					rotation_date_to=:rotation_date_to
				WHERE id=:rotationID
				AND rotation_number=:rotation_number
				AND congregation_ID=:congregation_ID");
			$stmt->bindParam(":rotationID",$_rotationID,PDO::PARAM_INT);
			$stmt->bindParam(":rotation_number",$_rotationNumber,PDO::PARAM_INT);
			$stmt->bindParam(":congregation_ID",$_congregationID,PDO::PARAM_INT);
			$stmt->bindParam(":rotation_date_from",$_rotationDateFrom,PDO::PARAM_STR);
			$stmt->bindParam(":rotation_date_to",$_rotationDateTo,PDO::PARAM_STR);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewRotation - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	deleteRotation - will delete a record from the rotation table 
	 * that matches the provided rotation id, rotation number, 
	 * and congregation id.
	 *
	 * @param string $_rotationID - rotation id to match.
	 * @param string $_rotationNumber - rotation number date to match.
	 * @param string $_congregationID - rotation congregation id date to match.
	 * @return integer containing the id of the affected rotation.
	 **/
	function deleteRotation($_rotationID,$_rotationNumber,$_congregationID){
		try{
			$stmt = $this->db->prepare("DELETE FROM rotation 
					WHERE id=:rotationID
				AND rotation_number=:rotation_number
				AND congregation_ID=:congregation_ID");
			$stmt->bindParam(":rotationID",$_rotationID,PDO::PARAM_INT);
			$stmt->bindParam(":rotation_number",$_rotationNumber,PDO::PARAM_INT);
			$stmt->bindParam(":congregation_ID",$_congregationID,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "deleteRole - ".$e->getMessage();
			die();
		}
	}

	// SUPPORTING CONGREGATION ================================================
	
	/**
	 *  getAllSupportingCongregation - will return all supporting congregations
	 * that currently exist in the supporting_congregation table.
	 *
	 * @return supportingCongregation $data - supportingCongregation
	 * objects to return.
	 **/
	function getAllSupportingCongregation(){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * FROM supporting_congregation");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'supportingCongregation');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllSupportingCongregation - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *  getSupportingCongregation - will return the supporting congregation 
	 * object that currently exist in the supporting_congregation table 
	 * and match the provided supporting congregtation id.
	 *
	 * @param string $_id - supporting congregation id to match.
	 * @return supportingCongregation $data - supportingCongregation
	 * objects to return.
	 **/
	function getSupportingCongregation($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM supporting_congregation
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'supportingCongregation');

			return $data;
		}
		catch(PDOException $e){
			echo "getSupportingCongregation - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *  getSupportingCongregationName - will return the supporting congregations
	 * that currently exist in the supporting_congregation table and match the
	 * provided congregation id.
	 *
	 * @param string $_congregationID - congregation id date to match.
	 * @return supportingCongregation $data - supportingCongregation
	 * objects to return.
	 **/
	function getSupportingCongregationName($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT name 
										FROM supporting_congregation
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getSupportingCongregationName - ".$e->getMessage();
			die();
		}
		return $data;
	}

	function getSupportingCongregtationForCongregation($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT sc.id as 'id', sc.name as 'name' 
										FROM supporting_congregation sc
										JOIN congregation_supporting cs
										ON cs.supporting_ID = sc.id
										WHERE cs.congregation_ID = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'supportingCongregation');

			return $data;
		}
		catch(PDOException $e){
			echo "getSupportingCongregation - ".$e->getMessage();
			die();
		}
		return $data;
	}
	function insertNewSupportingCongregation($_name,$_congregation){
		try{
			$stmt = $this->db->prepare("INSERT INTO supporting_congregation  
			(name) VALUES (:name)");
			$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
			$stmt->execute();

			$supportingID = $this->db->lastInsertId();

			$stmt = $this->db->prepare("INSERT INTO congregation_supporting
			VALUES (:congregation_ID, :supporting_ID)");
			$stmt->bindParam(":congregation_ID",$_congregation,PDO::PARAM_INT);
			$stmt->bindParam(":supporting_ID",$supporting_ID,PDO::PARAM_INT);
			$stmt->execute();
		}
		catch(PDOException $e){
			echo "insertNewAvailability - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	updateSupportingCongregation - will update a record in the 
	 * blackout_dates table with the provided information.
	 *
	 * @param string $_congregationID - congregation id to match.
	 * @param string $_blackoutDateTo - start blackout date to match 
	 *                                	and update.
	 * @param integer $_blackoutDateFrom - end blackout date to match
	 *                                     and update.
	 * @return integer $data - blackout date id to return.
	 **/
	function updateSupportingCongregation($_id,$_name,$_congregation=""){
		try{
			if($_congregation != ""){
				$stmt = $this->db->prepare("UPDATE supporting_congregation  
				name=:name WHERE id=:id");
				$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
				$stmt->bindParam(":id",$_id,PDO::PARAM_STR);
				$stmt->execute();

				$stmt = $this->db->prepare("UPDATE congregation_supporting
				SET congregation_ID=:congregation_ID
				WHERE congregation_ID=:congregation_ID
				AND supporting_ID=:supporting_ID");
				$stmt->bindParam(":congregation_ID",$_congregation,PDO::PARAM_INT);
				$stmt->bindParam(":supporting_ID",$_id,PDO::PARAM_INT);
			}
			else{
				$stmt = $this->db->prepare("UPDATE supporting_congregation  
				(name) VALUES (:name)");
				$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
				$stmt->execute();
			}
		}
		catch(PDOException $e){
			echo "updateSupportingCongregation - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	deleteSupportingCongregation - will delete a record from the
	 * supporting_congregation table that matches the provided 
	 * supporting congregation id.
	 *
	 * @param integer $_rotationID - supporting congregation id to match.
	 * @return integer containing the id of affected supporting congregation.
	 **/
	function deleteSupportingCongregation($_id){
		try{
			$stmt = $this->db->prepare("DELETE FROM supporting_congregation WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "deleteRole - ".$e->getMessage();
			die();
		}
	}

	// AVAILABILITY ===========================================================
	
	/**
	 *  getAllAvailability - will return all availability that currently
	 * exist in the availability table.
	 *
	 * @return availability $data - availability objects to return.
	 **/
	function getAllAvailability(){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * FROM availability");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'availability');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllAvailability - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *  getAvailabilityForDriver - will return the availability that currently
	 * exist in the availability table and matches the provided driver id.
	 *
	 * @param integer $_id - driver id of the availability to match.
	 * @return availability $data - availability objects to return.
	 **/
	function getAvailabilityForDriver($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * 
										FROM availability
										WHERE bus_driver_ID = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'availability');

			return $data;
		}
		catch(PDOException $e){
			echo "getAvailabilityForDriver - ".$e->getMessage();
			die();
		}
		return $data;
	}

	function getAvailabilityDatesForDriver($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT availability 
										FROM availability
										WHERE bus_driver_ID = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getAvailabilityDatesForDriver - ".$e->getMessage();
			die();
		}
		return $data;
	}

	function getAvailabilityTimeOfDayForDriver($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT availability 
										FROM availability
										WHERE bus_driver_ID = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetch(PDO::FETCH_ASSOC);

			return $data;
		}
		catch(PDOException $e){
			echo "getAvailabilityTimeOfDayForDriver - ".$e->getMessage();
			die();
		}
		return $data;
	}

	function insertNewAvailability($busDriverID,$availability,$time_of_day){
		try{
			$stmt = $this->db->prepare("INSERT INTO availability  
			VALUES (:busDriverID,:availability,:time_of_day)");
			$stmt->bindParam(":busDriverID",$busDriverID,PDO::PARAM_INT);
			$stmt->bindParam(":availability",$availability,PDO::PARAM_STR);
			$stmt->bindParam(":time_of_day",$time_of_day,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewAvailability - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	updateAvailability - will update a record in the blackout_dates table
	 * with the provided information.
	 *
	 * @param string $_congregationID - congregation id to match.
	 * @param string $_blackoutDateTo - start blackout date to match 
	 *                                	and update.
	 * @param integer $_blackoutDateFrom - end blackout date to match
	 *                                     and update.
	 * @return integer $data - blackout date id to return.
	 **/
	function updateAvailability($_busDriverID,$_availability,
								$_oldAvailability,$_time_of_day){
		try{
			$stmt = $this->db->prepare("UPDATE availability  
				SET availability=:availability,
					time_of_day=:time_of_day
				WHERE bus_driver_ID=:bus_driver_ID
				AND availability=:old_availability");
			$stmt->bindParam(":bus_driver_ID",$_busDriverID,PDO::PARAM_INT);
			$stmt->bindParam(":availability",$_availability,PDO::PARAM_STR);
			$stmt->bindParam(":old_availability",$_oldAvailability,PDO::PARAM_STR);
			$stmt->bindParam(":time_of_day",$_time_of_day,PDO::PARAM_STR);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewRotation - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	deleteAvailability - will delete a record from the
	 * availability table that matches the provided 
	 * driver id and availability date.
	 *
	 * @param integer $_date - bus driver id to match.
	 * @param string $_availability - availability date to match.
	 * @return integer containing the id of affected supporting congregation.
	 **/
	function deleteAvailability($_availability,$_busDriverID){
		try{
			$stmt = $this->db->prepare("DELETE FROM availability WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "deleteRole - ".$e->getMessage();
			die();
		}
	}

	// SCHEDULE ===============================================================

	/**
	 *  getAllSchedules - will return all schedules that currently exist in the
	 * schedule table as schedule objects.
	 * 
	 * @return [schedule] $data - array containing schedule objects to return.
	 */
	function getAllSchedules(){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * FROM schedule");
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'schedule');

			return $data;
		}
		catch(PDOException $e){
			echo "getAllSchedules - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *  getSchedulesById - will return the schedules that currently exist in 
	 * the schedule table and match the provided id as schedule objects.
	 *
	 * @param integer $_id - schedule id to match.
	 * @return [schedule] $data - array containing schedule objects to return.
	 */
	function getSchedulesById($_id){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * FROM schedule
										WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'schedule');

			return $data;
		}
		catch(PDOException $e){
			echo "getSchedulesById - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *  getSchedulesByDriver - will return the schedules that currently exist 
	 * in the schedule table and match the provided driver id as schedule
	 * objects.
	 *
	 * @param integer $_driverID - schedule driver id to match.
	 * @return [schedule] $data - array containing schedule objects to return.
	 */
	function getSchedulesByDriver($_driverID){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * FROM schedule
										WHERE bus_driver_ID = :driverID");
			$stmt->bindParam(":driverID",$_driverID,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'schedule');

			return $data;
		}
		catch(PDOException $e){
			echo "getSchedulesByDriver - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *  getSchedulesByStatus - will return the schedules that currently exist 
	 * in the schedule table and match the provided status id as schedule
	 * objects.
	 *
	 * @param integer $_statusID - schedule status id to match.
	 * @return [schedule] $data - array containing schedule objects to return.
	 */
	function getSchedulesByStatus($_statusID){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * FROM schedule
										WHERE status = :statusID");
			$stmt->bindParam(":statusID",$_statusID,PDO::PARAM_INT);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'schedule');

			return $data;
		}
		catch(PDOException $e){
			echo "getSchedulesByStatus - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *  getScheduleByDateInterval - will return the schedules that currently
	 * exist in the schedule table and match the provided date interval as 
	 * schedule objects.
	 *
	 * @param string $_dateFrom - starting schedule date to match.
	 * @param string $_dateTo - ending schedule date to match.
	 * @return [schedule] $data - array containing schedule objects to return.
	 */
	function getScheduleByDateInterval($_dateFrom,$_dateTo){
		try{
			$data = array();
			$stmt = $this->db->prepare("SELECT * FROM schedule s
										WHERE s.date BETWEEN :dateFrom
										AND :dateTo");
			$stmt->bindParam(":dateFrom",$_dateFrom,PDO::PARAM_STR);
			$stmt->bindParam(":dateTo",$_dateTo,PDO::PARAM_STR);
			$stmt->execute();

			$data = $stmt->fetchAll(PDO::FETCH_CLASS,'schedule');

			return $data;
		}
		catch(PDOException $e){
			echo "getSchedulesByStatus - ".$e->getMessage();
			die();
		}
		return $data;
	}

	/**
	 *	insertNewSchedule - will create a record in the schedule table
	 * with the provided information.
	 *
	 * @param string $_date - schedule date to add.
	 * @param string $_timeOfDay - schedule time of day of date to add.
	 * @param integer $_busDriverID - id of the bus driver assigned to the
	 *                               schedule to add.
	 * @param integer $_status - id of the status of the schedule to add.
	 * @return integer $data - id of the newly created schedule date.
	 **/
	function insertNewSchedule($_date,$_timeOfDay,$_busDriverID,$_status){
		try{
			$stmt = $this->db->prepare("INSERT INTO schedule  
			VALUES (0,:date,:time_of_day,:busDriverID,:status)");
			$stmt->bindParam(":date",$_date,PDO::PARAM_STR);
			$stmt->bindParam(":time_of_day",$_timeOfDay,PDO::PARAM_INT);
			$stmt->bindParam(":busDriverID",$_busDriverID,PDO::PARAM_INT);
			$stmt->bindParam(":status",$_status,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewAvailability - ".$e->getMessage();
			die();
		}
	}

	/**
	 *	updateSchedule - will update a record in the blackout_dates table
	 * with the provided information.
	 *
	 * @param integer $_id - schedule id to match.
	 * @param string $_date - schedule date value to update.
	 * @param integer $_timeOfDay - id of time of day to update.
	 * @param integer $_busDriverID - bus driver id to match.
	 * @param integer $_status - id of the schedule status to update.
	 * @return integer $data - schedule id that has been updated.
	 **/
	function updateSchedule($_id,$_date,$_timeOfDay,$_busDriverID,$_status){
		try{
			$stmt = $this->db->prepare("UPDATE schedule s
				SET s.date=:date,
					time_of_day=:time_of_day 
				WHERE bus_driver_ID=:bus_driver_ID
				AND s.id=:id");
			$stmt->bindParam(":date",$_date,PDO::PARAM_STR);
			$stmt->bindParam(":old_date",$_oldDate,PDO::PARAM_STR);
			$stmt->bindParam(":time_of_day",$_timeOfDay,PDO::PARAM_INT);
			$stmt->bindParam(":busDriverID",$_busDriverID,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewRotation - ".$e->getMessage();
			die();
		}
	}

	/**
	 * 	deleteSchedule - will delete a record from the schedule table
	 * that matches the provided date, time of day, and driver id.
	 *
	 * @param string $_busDriverID - bus driver id to match.
	 * @param string $_busDriverID - bus driver id to match.
	 * @param integer $_availability - availability date to match.
	 * @return integer containing the id of affected supporting congregation.
	 **/
	function deleteSchedule(){
		try{
			$stmt = $this->db->prepare("DELETE FROM schedule WHERE id = :id");
			$stmt->bindParam(":id",$_id,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "deleteRole - ".$e->getMessage();
			die();
		}
	}
 }