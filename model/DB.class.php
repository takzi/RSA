<?php
/**
 * Class DB.class.php
 * @auth Anthony Perez
 * @date 09/11/17
 **/
 
 /**
 * 
 */
 class DB{
 	function __construct(){
 		require_once("availability.class.php");
 		require_once("blackoutDates.class.php");
 		require_once("busDriver.class.php");
		require_once("congregation.class.php");
		require_once("holiday.class.php");
		require_once("role.class.php");
		require_once("rotation.class.php");
		require_once("supportingCongregation.class.php");
		require_once("user.class.php");

 		require_once("dbInfo.php");

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
 	 *  getAllUsers - will truen all current existing
 	 * users in the user table.
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
	 *	getUserFullName - will return full name
	 * ('firstName' 'lastName') for a user 
	 * that currently exist in the users table
	 * and matches the provided id.
	 *
	 * @param inte $_id - user id to match.
	 * @return array $data - array containing the 
	 * desired user's full name.
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
			echo "getUserEmail - ".$e->getMessage();
			die();
		}
	}

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
	
	function getAllHolidays(){

		var_dump("in getAllHolidays()");

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
			echo "getAllHolidays - ".$e->getMessage();
			die();
		}
		return $data;
	}
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
			echo "getHolidayName - ".$e->getMessage();
			die();
		}
		return $data;
	}
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
	function deleteHoliday($_name, $_date){
		try{
			$stmt = $this->db->prepare("DELETE FROM holiday 
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
	function insertNewBlackoutdate($_congregationID,$_blackoutDateTo,$_blackoutDateFrom){
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
	function updateRotation($_rotationID,$_rotationNumber,
		$_congregationID,$_rotationDateFrom,$_rotationDateTo){
		try{
			$stmt = $this->db->prepare("UPDATE rotation  
				SET rotation_date_from:rotation_date_from,
					rotation_date_to:rotation_date_to
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
	function updateSupportingCongregation($_id,$_name,$_congregation=""){
		try{
			if($_congregation != ""){
				$stmt = $this->db->prepare("UPDATE supporting_congregation  
				(name) VALUES (:name)");
				$stmt->bindParam(":name",$_name,PDO::PARAM_STR);
				$stmt->execute();

				$stmt = $this->db->prepare("UPDATE congregation_supporting
				(congregation_ID) VALUES (:congregation_ID)
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
			echo "insertNewAvailability - ".$e->getMessage();
			die();
		}
	}
	function deleteSupportingCongregation(){
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
	function updateAvailability(){}
	function deleteAvailability(){
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

	function insertNewSchedule($date,$time_of_day,$busDriverID){
		try{
			$stmt = $this->db->prepare("INSERT INTO schedule  
			VALUES (:date,:time_of_day,:busDriverID)");
			$stmt->bindParam(":date",$date,PDO::PARAM_STR);
			$stmt->bindParam(":time_of_day",$time_of_day,PDO::PARAM_INT);
			$stmt->bindParam(":busDriverID",$busDriverID,PDO::PARAM_INT);
			$stmt->execute();

			print $this->db->lastInsertId();
		}
		catch(PDOException $e){
			echo "insertNewAvailability - ".$e->getMessage();
			die();
		}
	}
	function updateSchedule(){}
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