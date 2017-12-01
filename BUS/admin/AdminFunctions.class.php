<?php
/**
 * AdminFunctions holds all of the logic for 
 * administrative functions.
 *
 *
 * @author     Kristen Merritt
 * @author     Tiandre Turner
 * @author     Anthony Perez
 * @version    Release: 1.0
 * @date       11/15/2017
 */

if(isset($_POST['action'])){
		print_r("in action");
		$action = $_POST['action'];

		switch ($action) {
			case 'updateCongregation':
				//$data = generateCongregationSchedule();
				$data = "Updating Congregation";
				print_r($data);
				break;
			
			case 'updateBusDriver':
				$data = "Updating Driver";
				print_r($data);
				break;
		}
	}

class AdminFunctions{
	private $path_to_root; // provide the location of the root of public_html
	private $db;           // the database object
	private $sanitizer;	   // sanitizer object that holds sanitization functionality


	/**
	 * Constructor for the AdminFunctions object. Sets the path,
	 * the database, and the sanitizer.
	 * 
	 * @param [string] $page         [provides the page name]
	 * @param [string] $path_to_root [provides the path to the root]
	 */
	public function __construct($page, $path_to_root){
		$this->path_to_root = $path_to_root;

		require_once($this->path_to_root.'../model/DB.class.php');
		$this->db = new DB($this->path_to_root);

		require_once($this->path_to_root.'../BUS/Sanitizer.class.php');
		$this->sanitizer = new Sanitizer();
	}

	/**
	 * Inserts the admin home page buttons.
	 * 
	 * @param  [string] $name [name of the admin]
	 * @param  [int]    $role [role of the admin]
	 * @return [string]       [html string to be inserted]
	 */
	function insertAdminHome($name, $role){
		$topButtons = "";
		$bottomButtons = "";

		if($role == 1){ // general admin
			$topButtons = "<a href='admin_bus.php'><div class='admin_home_button'>Bus Drivers</div></a>\n
						  <a href='admin_cong.php'><div class='admin_home_button'>Congregations</div></a>\n";

			$bottomButtons = "<a href='admin_add_newadmin'><div class='admin_home_button'>Add New Admin</div></a>\n
							 <a href='admin_user.php'><div class='admin_home_button'>Users</div></a>\n";
		} elseif($role == 2){ // congregation admin
			$topButtons = "<a href='admin_cong.php'><div class='admin_home_button'>Congregations</div></a>\n
						  <a href='admin_user.php'><div class='admin_home_button'>Users</div></a>\n";
		} elseif($role == 3){ // bus driver admin
			$topButtons = "<a href='admin_bus.php'><div class='admin_home_button'>Bus Drivers</div></a>\n
						<a href='admin_user.php'><div class='admin_home_button'>Users</div></a>\n";
		}

		return "<h1 id='profile_h1'>".$name."</h1>\n
					<div id='profile_container' class='clearfix'>\n
						<div id='topButtons' class='clearfix'>\n
							".$topButtons."
						</div>\n
						<div id='botButtons' class='clearfix'>\n
							".$bottomButtons."
						</div>\n
					</div>\n";
	}

	/**
	 * Inserts the congregation or bus drivers
	 * onto the admin's page for them.
	 * 
	 * @param  [string] $type [congregation or bus driver]
	 * @return [string]       [html to insert onto page]
	 */
	function insertCongBusAdmin($type){
		$input_name =  ($isBus = $type == "Bus Drivers") ? "bus" : "cong";
		$input_value = $isBus ? "Bus Driver" : "Congregation";
		return "<div id='adminLink'>\n
					<a href='".$this->path_to_root."templates/admin/profile.php'>Admin Home</a>\n 
					>
					<a href='#'>".$type."</a>\n
				</div>\n
				<h1>".$type."</h1>\n
					<div id='form'>\n
						<input type='text' class='text' name='" . $input_name . "_name' value='" . $input_value . " Name'> 
						<input type='button' value='Add Now'>\n
						<input type='button' id='gen".$input_name."But' value='Generate New Schedule'>
						<a href='".$this->path_to_root."templates/congregation_schedule.php'><input type='button' value='View Current Schedule'></a>
					</div>\n
					<script type='text/javascript' src='".$this->path_to_root."js/reset.js'></script>";
	}

	/**
	 * Inserts the users
	 * onto the admin's page for them.
	 * 
	 * @return [string]       [html to insert onto page]
	 */
	function insertUserAdmin(){
		return "<div id='adminLink'>\n
					<a href='".$this->path_to_root."templates/admin/profile.php'>Admin Home</a>\n 
					>
					<a href='#'>Users</a>\n
				</div>\n
				<h1>Users</h1>\n
					<div id='form'>\n
						<input type='text' class='text' name='user_name' value='User Name'> 
						<input type='button' value='Add'>\n
					</div>\n
					<script type='text/javascript' src='".$this->path_to_root."js/reset.js'></script>";
	}

	/**
	 * Retreives all of the congregations, then inserts
	 * them into the admin's page for them.
	 * 
	 * @return [string] [html of the congregation data]
	 */
	function insertCongregationsIntoAdminPage(){
		$congregations = $this->db->getAllCongregations();
		$tr = "";
		foreach($congregations as $congregation){
			$tr .= $this->getHTMLSnippet($congregation->getID(), $congregation->getName(), 'c');
		}
		return "<table id='congregations'>". 
				$tr
			 . "</table>";
	}

	/**
	 * Retreives all of the bus drivers, then inserts
	 * them into the admin's page for them.
	 * 
	 * @return [string] [html of the bus drivers' data]
	 */
	function insertBusDriversIntoAdminPage(){
		$drivers = $this->db->getAllBusDrivers();
		$tr = "";
		foreach($drivers as $driver){
			$id = $driver->getID();
			$contactID = $driver->getContactID();
			$user = $this->db->getUser($contactID)[0];
			$tr .= $this->getHTMLSnippet($id, $user->getWholeName(), 'd');
		}
		return "<table id='congregations'>".
				$tr
			.  "</table>";
	}

	/**
	 * Retreives all of the users, then inserts
	 * them into the admin's page for them.
	 * 
	 * @return [string] [html of the users' data]
	 */
	function insertUsersIntoAdminPage(){
		$users = $this->db->getAllUsers();
		$tr = "";
		foreach($users as $user){
			$tr .= $this->getHTMLSnippet($user->getID(), $user->getWholeName(), 'u');
		}
		return "<table id='congregations'>".
				$tr
			.  "</table>";
	}

	/**
	 * Inserts the blackout dates provides from the DB
	 * into the edit congregation page.
	 * 
	 * @param  [int] $id    [congregation ID]
	 * @return [string]     [html based off of data]
	 */
	function insertBlackoutDatesIntoEditCongregation($id){
		$blackoutDates = $this->db->getBlackoutdatesForCongregation($id);

		if(empty($blackoutDates)){
			return "<p class='date-inputted' value=''>No blackout dates</p>";
		}

		$paragraphDates = "";

		foreach($blackoutDates as $blackoutDate){
			$fromDate = $blackoutDate->getFromDate();
			$toDate = $blackoutDate->getToDate();
			$date = $this->formatDate($fromDate, "m/d/Y - ") . $this->formatDate($toDate, "m/d/Y");
			$paragraphDates .= "<p class='date-inputted' value='" . $date ."'>". $date . "</p>\n";
		}

		return $paragraphDates;
	}

	/**
	 * Inserts the blackout dates into the database
	 * 
	 * @param  [int] $_id    [congregation ID]
	 * @param  [string] $_from_date  [From Date]
	 * @param  [string] $_to_date    [To Date]
	 */
	function insertBlackoutDatesIntoDB($_id, $_from_date, $_to_date){
		 $this->db->insertNewBlackoutdate($_id, $_from_date, $_to_date);
	}


	/**
	 * Inserts the availability dates provided from the DB
	 * into the edit bus driver page.
	 * 
	 * @param  [int] $id    [bus driver ID]
	 * @return [string]     [html of data]
	 */
	function insertAvailablityIntoEditDriver($id){
		$availabilities = $this->db->getAvailabilityForDriver($id);
		if(empty($availabilities)){
			return "<p class='date-inputted' value=''>No availability dates</p>";
		}

		$date = "";
		
		$paragraphDates = "";
		foreach($availabilities as $availability){
			$date = $this->formatDate($availability->getAvailability(), "m/d/Y") . ' - ' . $availability->getTimeOfDay();
			$paragraphDates .= "<p class='date-inputted' value='" . $date ."'>". $date . "</p>\n";
		}

		return $paragraphDates;
		
	}

	/**
	 * Inserts the availability dates into the database
	 * 
	 * @param  [int] $_id    [bus driver ID]
	 * @param  [string] $_from_date  [Requested Date]
	 * @param  [int] $_time_of_day    [Requested Time Of Day]
	 */
	function insertAvailabilityDatesIntoDB($_id, $_date, $_time_of_day){
		 $this->db->insertNewAvailability($_id, $_date, $_time_of_day);
	}

	/**
	 * Resets the password of a user to
	 * rahin123
	 * 
	 * @param  [string] $_type [congregation ('c') or bus driver ('b')]
	 * @param  [int] $_id      [ID of the congregation or bus driver]
	 */
	function resetPassword($_type, $_id){
		if($_type == 'c'){
			$congregation = $this->getCongregation($_id)[0];
			$user = $this->getUser($congregation->getContactID())[0];
			$this->db->updateUser($user->getID(),$user->getFirstName(), $user->getLastName(), $user->getRole(), $user->getEmail(), "rahin123");
			//echo "<script type='text/javascript'>alert('Password reset!');</script>";
		}else if($_type == 'd'){
			$driver = $this->getBusDriver($_id)[0];
			$this->db->updateUser($driver->getID(),$driver->getFirstName(), $driver->getLastName(), $driver->getRole(), $driver->getEmail(), "rahin123");
			//echo "<script type='text/javascript'>alert('Password reset!');</script>";
		}else{
			$user = $this->getUser($_id)[0];
			$this->db->updateUser($user->getID(),$user->getFirstName(), $user->getLastName(), $user->getRole(), $user->getEmail(), "rahin123");
		}
	}

	/**
	 * Allows the user to change their password
	 *
	 * @param  [int] $_id      [ID of the congregation or bus driver]
	 * @param  [string] $_fName [firstName of the user to update]
	 * @param  [string $_lName  [lastName of the user to update]
	 * @param  [integer $_roleID [roleid of the user to update]
	 * @param  [string] $_email  [email of the user to update]
	 * @param  [string] $_password [pasword of the user to update]
	 */
	function updatePassword($_id, $_fName, $_lName, $_roleID, $_email, $_password){
		$this->db->updateUser($_id,$_fName, $_lName, $_roleID, $_email, $_password);
	}

	function updateCongregation($_id, $_contactID, $_name){
		$data = $this->db->updateCongregation($_id, $_contactID, $_name);
		return $data;
	}

	function updateBusDriver($_id, $_contactID, $_contactNumber){
		$data = $this->db->updateBusDriver($_id, $_contactID, $_contactNumber);
		return $data;
	}



	/**
	 * Helper function used to get HTML for bus driver and 
	 * congregation admin pages.
	 * 
	 * @param  [int] $id   [id of the cong / bus driver / user]
	 * @param  [string] $name [name of the cong / driver / user]
	 * @param  [string] $type [cong, driver or user]
	 * @return [string]       [html of the data provided]
	 */
	private function getHTMLSnippet($id, $name, $type){
		return "<tr>
					<td>" . $name ." <div class='tb-container'> <a href='admin_edit_". $this->getType($type, 'cong', 'bus','user') . ".php?" . $this->getType($type, 'congregation', 'driver', 'user') . "=" . $id ."'>\n
									 	<input type='button' class='tb' name='" . $name . "' value='Edit'>\n
									 </a>\n

									 <a href=''>\n
									 	<input type='button' class='tb tb-delete' name='delete-".$name."' value='Delete'>\n
									 </a>\n

									 <a href=''>\n
									 	<input type='button' class='tb' name='email-".$name."' value='Email'>\n
									 </a>\n

									 <a href=\"#\" onclick=\"reset('". $type . "', ". $id . ")\">\n
									 	<input type='button' class='tb' value='Reset Password'>\n
									 </a></div>\n
					</td>
				</tr>";
	}	

	/**
	 * Helper function to retreive the type of 
	 * account.
	 * 
	 * @param  [string] $type [c, d, or u]
	 * @param  [string] $cong ['cong']
	 * @param  [string] $bus  ['bus']
	 * @param  [string] $user ['user']
	 * @return [string]       [returns cong, bus, or user]
	 */
	private function getType($type, $cong, $bus, $user){
		switch($type){
			case 'c':
				return $cong;
			case 'd':
				return $bus;
			case 'u':
				return $user;
		}
	}

	/**
	 * Returns the user object from an ID
	 * @param  [int] $_id [id of the user]
	 * @return [User]      [user object]
	 */
	function getUser($_id){
		return $this->db->getUser($_id);
	}

	/**
	 * Returns the congregation object from
	 * an ID.
	 * 
	 * @param  [int] $id       [id of the congregation]
	 * @return [Congregation]  [congregation object]
	 */
	function getCongregation($id){
		return $this->db->getCongregation($id);
	}

	/**
	 * Returns the congregation object from
	 * an user ID.
	 * 
	 * @param  [int] $id       [id of the current user]
	 * @return [Congregation]  [congregation object]
	 */
	function getCongregationByContactID($id){
		return $this->db->getCongregationByContactID($id);
	}

	/**
	 * Returns the bus driver object from an
	 * ID.
	 * 
	 * @param  [int] $id    [id of the bus driver]
	 * @return [BusDriver]  [bus driver object]
	 */
	function getBusDriver($id){
		$busDriver = $this->db->getBusDriver($id);
		$busDriverId = $busDriver[0]->getContactID();
		return $this->db->getUser($busDriverId);
	}

	/**
	 * Returns the bus driver object from an
	 * user ID.
	 * 
	 * @param  [int] $id    [id of the current user]
	 * @return [BusDriver]  [bus driver object]
	 */
	function getBusDriveryByContactID($id){
		return $this->db->getBusDriverByContactID($id);
	}

	/**
	 * Forms a date object.
	 * 
	 * @param  [string] $date   [the date you want to format]
	 * @param  [string] $format [the format you want the date in]
	 * @return [date]           [date formatted]
	 */
	function formatDate($date,$format){
		return date($format, strtotime($date));
	}
}


?>