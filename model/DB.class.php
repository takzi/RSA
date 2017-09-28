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
 		require_once("dbInfo.php");
 		require_once("busDriver.class.php");
 		require_once("congregation.class.php");
		require_once("user.class.php");
		require_once("role.class.php");

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

	function insertNewUser($_firstName, $_lastName, $_roleID,
							$_email, $_password){}
	function updateUser($_id, $_firstName, $_lastName, $_roleID,
						$_email, $_password){}
	function deleteUser($_id){}

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
			$stmt->bindParam(":name",$_name,PDO::PARAM_INT);
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
	function insertNewRole($_role, $_name){}
	function updateRole($_id, $_role){}
	function delteRole($_id){}

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
	function insertNewCongregation($_contactID, $_name){}
	function updateCongregation($_id, $_contactID, $_name){}
	function deleteCongregation($_id){}

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
	function insertNewBusDriver($_contactID, $_contactNumber){}
	function updateBusDriver($_id, $_contactID, $_contactNumber){}
	function deleteBusDriver($_id){}

	// HOLIDAYS ===============================================================
	
	function getAllHolidays(){}
	function getHoliday($_name, $_date){}
	function getHolidayName($_date){}
	function getHolidayDates($_name){}
	function getHolidayDatesForCongregation($_congregation){}
	function insertNewHoliday($_name, $_date, $_congregation){}
	function updateHoliday($_name, $_date, $_congregation){}
	function deleteHoliday($_name, $_date){}

	// BLACKOUT DATES =========================================================
	


	// ROTATIONS ==============================================================
	


	// SUPPORTING CONGREGATION ================================================
	

	// AVAILABILITY ===========================================================
	


	// SCHEDULE ===============================================================

 }