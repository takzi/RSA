<?php
session_start();
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
	date_default_timezone_set("America/New_York");
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
		$id_name = $isBus ? "createSchedule" : "genScheBut";
		return "<div id='adminLink'>\n
					<a href='".$this->path_to_root."templates/admin/profile.php'>Admin Home</a>\n 
					>
					<a href='#'>".$type."</a>\n
				</div>\n
				<h1>".$type."</h1>\n
					<div id='form'>\n
						<a href='".$this->path_to_root."templates/admin/admin_add_".$input_name."'><input type='button' value='Add New'></a>\n
						<input type='button' id='". $id_name ."' value='Generate New Schedule'>
						<a href='".$this->path_to_root."templates/congregation_schedule.php'><input type='button' value='View Current Schedule'></a>
					</div>";
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
					</div>";
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
			return " ";
		}

		$paragraphDates = "";

		foreach($blackoutDates as $blackoutDate){
			$fromDate = $blackoutDate->getFromDate();
			$toDate = $blackoutDate->getToDate();
			$date = $this->formatDate($fromDate, "m/d/Y - ") . $this->formatDate($toDate, "m/d/Y");
			//$paragraphDates .= "<p class='date-inputted' value='" . $date ."'>". $date . "</p>\n";
			$paragraphDates .=  $date ."\n";
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
			//$paragraphDates .= "<p class='date-inputted' value='" . $date ."'>". $date . "</p>\n";
			$paragraphDates .=  $date ."\n";
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
			$this->updateUser($user->getID(),$user->getFirstName(), $user->getLastName(), $user->getRole(), $user->getEmail(), "raihn123");
			//echo "<script type='text/javascript'>alert('Password reset!');</script>";
		}else if($_type == 'd'){
			$driver = $this->getBusDriver($_id)[0];
			$this->updateUser($driver->getID(),$driver->getFirstName(), $driver->getLastName(), $driver->getRole(), $driver->getEmail(), "raihn123");
			//echo "<script type='text/javascript'>alert('Password reset!');</script>";
		}else{
			$user = $this->getUser($_id)[0];
			$this->updateUser($user->getID(),$user->getFirstName(), $user->getLastName(), $user->getRole(), $user->getEmail(), "raihn123");
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
		$this->updateUser($_id,$_fName, $_lName, $_roleID, $_email, $_password);
	}

	function updateCongregation($_id, $_contactID, $_name, $_userWholeName){
		$user = $this->getUser($_contactID)[0];
		$data = $this->db->updateCongregation($_id, $_contactID, $_name);
		$name = explode(" ", $_userWholeName);
		for($index = 1; $index < count($name); $index++){
			$lastName .= $name[$index] . " ";
		}
		
		$this->updateUser($_contactID, $name[0], trim($lastName), $user->getRole(), $user->getEmail(), $user->getPassword())
;
		return $data;
	}

	function updateBusDriver($_id, $_name, $_contactNumber){
		$user = $this->getBusDriver($_id)[0];
		$name = explode(" ", $_name);
		for($index = 1; $index < count($name); $index++){
			if(!empty($name[$index]))
				$last .= $name[$index] . " ";
		}
		$this->updateUser($user->getID(), $name[0], trim($last), $user->getRole(), $user->getEmail(), $user->getPassword());
		$data = $this->db->updateBusDriver($_id, $user->getID(), $_contactNumber);
		return $data;
	}

	function updateUser($_id, $_fName, $_lName, $_roleID, $_email, $_password){
		$this->db->updateUser($_id,$_fName, $_lName, $_roleID, $_email, $_password);
	}

	function emailUser($_idTo,$_userType,$_message){
		//mail($_email,$_subject,$_message);
		$email_from = $_SESSION['email'];
		$subject = "RAIHN System Message";
		if($_userType == 'c'){
			$_uid = $this->db->getCongregationContactID($_idTo);
			$uid = $_uid["contact_ID"];
		}
		else{
			$_uid = $this->db->getBusDriverContactID($_idTo);
			$uid = $_uid["contact_ID"];
		}
		$_email_to = $this->db->getUserEmail($uid);
		$email_to = $_email_to["email"];

		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <'.$email_from.'>' . "\r\n";

		mail($email_to,$subject,$_message,$headers);
		return true;
	}

	function emailAdmin($_message){
		$email_from = $_SESSION['email'];
		$subject = "RAIHN System Message";
		$userRole = $_SESSION['role'];

		switch ($userRole) {
			case 4:
				# cong
				$_email_to = $this->db->getCongregationSchedulerEmail();
				$email_to = $_email_to["email"];
				break;
			
			case 5:
				# bus driver
				$_email_to = $this->db->getCongregationSchedulerEmail();
				$email_to = $_email_to["email"];
				break;
		}
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: <'.$email_from.'>' . "\r\n";

		mail($email_to,$subject,$_message,$headers);
		return true;
	}

	function updateBlackoutDates($_congregationID, $_from_date, $_to_date){
		$this->db->updateBlackoutDates($_congregationID, $_from_date, $_to_date);
	}

	function delete($_type, $_id, $_name){
		switch($_type){
			case 'c':
				$this->db->deleteCongregation($_id);
				break;
			case 'd':
				$this->db->deleteBusDriver($_id);
				break;
			case 'u':
				$this->db->deleteUser($_id);
				break;
			default:
				return "Unable to delete";
		}

		return "Deleted " + $_name;

	}

	function generateBusDriverSchedule(){
		//$DB = new DB('');

		//get all availability.
		$availabilities = $this->db->getAllAvailability();

		$lastRot = $this->db->getLastRotationID();
		$lastRotID = $lastRot[0];

		$lastDate = $this->db->getNextRotationDate();
		$lastDateStr = $lastDate[0];

		$dateStart = DateTime::createFromFormat('Y-m-d',$lastDateStr);
		date_add($dateStart,date_interval_create_from_date_string("7 days"));
		$dateEnd = DateTime::createFromFormat('Y-m-d',$lastDateStr);
		date_add($dateEnd,date_interval_create_from_date_string("91 days"));

		$interval = DateInterval::createFromDateString("1 days");
		$period = new DatePeriod($dateStart,$interval,$dateEnd);

		$rotDates = array();
		$counter = 1;
		foreach ($period as $date) {
			$rotDates[$counter] = $date;
			$counter++;
		}

		$rotDatesArr = array();
		$possibilitiesArr = array();
		for($i=1; $i<=count($rotDates);$i++){
			$curDate = $rotDates[$i]->format('Y-m-d');
			$rotDatesArr[$curDate] = array();
			$congs = array("Any"=>"","Morning"=>"","Afternoon"=>"");
			$possibilitiesArr[$curDate] = $congs;
			foreach($availabilities as $availability){
				if($availability->getAvailability() == $curDate){
					$possibilitiesArr[$curDate][$availability->getTimeOfDay()] .= ",".$availability->getBusDriverID();
					$possibilitiesArr[$curDate][$availability->getTimeOfDay()] = trim($possibilitiesArr[$curDate][$availability->getTimeOfDay()],",");
				}
			}
		}

		foreach($rotDatesArr as $date => $blah){
			foreach ($possibilitiesArr as $possibilityDate => $possibilities) {
				if($date == $possibilityDate){
					if($possibilities["Any"] != "" && $possibilities["Morning"] != "" && $possibilities["Afternoon"] != ""){
						$anyTime = explode(',',$possibilities["Any"]);
						$morningOnly = explode(',',$possibilities["Morning"]);
						$afternoonOnly = explode(',',$possibilities["Afternoon"]);

						if(count($morningOnly) >= 2 && count($afternoonOnly) >= 2){
							//Have enough drivers from morning and afternoon to fill
							//primary and backup roles
							$morningNum = count($morningOnly);
							$morningRadomNumber1 = rand(0,($morningNum-1));
							$morningRadomNumber2 = $morningRadomNumber1;
							while($morningRadomNumber2 == $morningRadomNumber1){
								$morningRadomNumber2 = rand(0,($morningNum-1));
							}

							$afternoonNum = count($afternoonOnly);
							$afternoonRadomNumber1 = rand(0,($afternoonNum-1));
							$afternoonRadomNumber2 = $afternoonRadomNumber1;
							while($afternoonRadomNumber2 == $afternoonRadomNumber1){
								$afternoonRadomNumber2 = rand(0,($afternoonNum-1));
							}

							$rotDatesArr[$date] = array("Morning"=>array(
															"Primary"=>$morningOnly[$morningRadomNumber1],
															"Backup"=>$morningOnly[$morningRadomNumber2]),
														"Afternoon"=>array(
															"Primary"=>$afternoonOnly[$afternoonRadomNumber1],
															"Backup"=>$afternoonOnly[$afternoonRadomNumber2])
														);
							
						}
						else if(count($morningOnly) < 2 && count($afternoonOnly) >= 2){
							//	Only enough afternoon drivers to fill primary and backup,
							//morning should be aggregated with anytime drivers to compensate
							$morningWithAnyTime = array_merge($morningOnly,$anyTime);

							$morningNum = count($morningWithAnyTime);
							$morningRadomNumber1 = rand(0,($morningNum-1));
							$morningRadomNumber2 = $morningRadomNumber1;
							while($morningRadomNumber2 == $morningRadomNumber1){
								$morningRadomNumber2 = rand(0,($morningNum-1));
							}

							$afternoonNum = count($afternoonOnly);
							$afternoonRadomNumber1 = rand(0,($afternoonNum-1));
							$afternoonRadomNumber2 = $afternoonRadomNumber1;
							while($afternoonRadomNumber2 == $afternoonRadomNumber1){
								$afternoonRadomNumber2 = rand(0,($afternoonNum-1));
							}

							$rotDatesArr[$date] = array("Morning"=>array(
															"Primary"=>$morningWithAnyTime[$morningRadomNumber1],
															"Backup"=>$morningWithAnyTime[$morningRadomNumber2]),
														"Afternoon"=>array(
															"Primary"=>$afternoonOnly[$afternoonRadomNumber1],
															"Backup"=>$afternoonOnly[$afternoonRadomNumber2])
														);
						}
						else if(count($morningOnly) >= 2 && count($afternoonOnly) < 2){
							//	Only enough morning drivers to fill primary and backup,
							//afternoon should be aggregated with anytime drivers to compensate
							$afternoonWithAnyTime = array_merge($afternoonOnly,$anyTime);
							
							$morningNum = count($morningOnly);
							$morningRadomNumber1 = rand(0,($morningNum-1));
							$morningRadomNumber2 = $morningRadomNumber1;
							while($morningRadomNumber2 == $morningRadomNumber1){
								$morningRadomNumber2 = rand(0,($morningNum-1));
							}

							$afternoonNum = count($afternoonWithAnyTime);
							$afternoonRadomNumber1 = rand(0,($afternoonNum-1));
							$afternoonRadomNumber2 = $afternoonRadomNumber1;
							while($afternoonRadomNumber2 == $afternoonRadomNumber1){
								$afternoonRadomNumber2 = rand(0,($afternoonNum-1));
							}

							$rotDatesArr[$date] = array("Morning"=>array(
															"Primary"=>$morningOnly[$morningRadomNumber1],
															"Backup"=>$morningOnly[$morningRadomNumber2]),
														"Afternoon"=>array(
															"Primary"=>$afternoonWithAnyTime[$afternoonRadomNumber1],
															"Backup"=>$afternoonWithAnyTime[$afternoonRadomNumber2])
														);
						}
						else if(count($morningOnly) < 2 && count($afternoonOnly) < 2 && count($anyTime) >= 2){
							//both have less than 2, so anytime will be split between them
							$alwaysNum = count($anyTime);

							$firstHalf = array_splice($anyTime, 0, $alwaysNum / 2);
							$secondHalf = array_splice($anyTime, $alwaysNum / 2);

							$morningWithAnyTime = array_merge($morningOnly,$firstHalf);
							$$afternoonWithAnyTime = array_merge($afternoonOnly,$secondHalf);

							$morningNum = count($morningWithAnyTime);
							$morningRadomNumber1 = rand(0,($morningNum-1));
							$morningRadomNumber2 = $morningRadomNumber1;
							while($morningRadomNumber2 == $morningRadomNumber1){
								$morningRadomNumber2 = rand(0,($morningNum-1));
							}

							$afternoonNum = count($afternoonWithAnyTime);
							$afternoonRadomNumber1 = rand(0,($afternoonNum-1));
							$afternoonRadomNumber2 = $afternoonRadomNumber1;
							while($afternoonRadomNumber2 == $afternoonRadomNumber1){
								$afternoonRadomNumber2 = rand(0,($afternoonNum-1));
							}

							$rotDatesArr[$date] = array("Morning"=>array(
															"Primary"=>$morningWithAnyTime[$morningRadomNumber1],
															"Backup"=>$morningWithAnyTime[$morningRadomNumber2]),
														"Afternoon"=>array(
															"Primary"=>$afternoonWithAnyTime[$afternoonRadomNumber1],
															"Backup"=>$afternoonWithAnyTime[$afternoonRadomNumber2])
														);
						}
						else if(count($anyTime) >= 2 && count($morningOnly) < 1 && count($afternoonOnly) < 1){
							$alwaysNum = count($anyTime);

							$firstHalf = array_splice($anyTime, 0, $alwaysNum / 2);
							$secondHalf = array_splice($anyTime, $alwaysNum / 2);

							$morningNum = count($firstHalf);
							$morningRadomNumber1 = rand(0,($morningNum-1));
							$morningRadomNumber2 = $morningRadomNumber1;
							while($morningRadomNumber2 == $morningRadomNumber1){
								$morningRadomNumber2 = rand(0,($morningNum-1));
							}

							$afternoonNum = count($secondHalf);
							$afternoonRadomNumber1 = rand(0,($afternoonNum-1));
							$afternoonRadomNumber2 = $afternoonRadomNumber1;
							while($afternoonRadomNumber2 == $afternoonRadomNumber1){
								$afternoonRadomNumber2 = rand(0,($afternoonNum-1));
							}

							$rotDatesArr[$date] = array("Morning"=>array(
															"Primary"=>$firstHalf[$morningRadomNumber1],
															"Backup"=>$firstHalf[$morningRadomNumber2]),
														"Afternoon"=>array(
															"Primary"=>$secondHalf[$afternoonRadomNumber1],
															"Backup"=>$secondHalf[$afternoonRadomNumber2])
														);
						}
					}
					else{
						return "availability missing to complete schedule.";
						break 3;
					}
				}
			}
		}

		if(!empty($rotDatesArr[date_format($dateStart, 'Y-m-d')])){
			foreach ($rotDatesArr as $date => $day) {
			 	foreach ($day as $timeOfDay => $driverStatus) {
			 		foreach ($driverStatus as $time => $driver) {
			 			$_time = ($time == "Primary"?1:2);
				 		$_timeOfDay = ($timeOfDay == "Morning"?2:3);
				 		$this->db->insertNewSchedule($date,$timeOfDay,$time,$driver,1);
			 		}
			 	}
			}
			return "Bus Driver Schedule Generation Complete.";
		}
	}// end generateBusDriver

	function generateCongregationSchedule(){
		//$DB = new DB("");

		$lastRot = $this->db->getLastRotationID();
		$lastRotID = $lastRot[0];

		$lastDate = $this->db->getNextRotationDate();
		$lastDateStr = $lastDate[0];

		// get the blackout dates for the next rotattion period
		$blackouts = $this->db->getAllBlackoutDates();
		$blackoutArr = array();
		foreach ($blackouts as $blackout) {
			$blackoutArr[$blackout->getCongregationID()] = "{$blackout->getFromDate()}";
		}

		//get next rotation dates
		$dateStart = DateTime::createFromFormat('Y-m-d',$lastDateStr);
		date_add($dateStart,date_interval_create_from_date_string("7 days"));
		$dateEnd = DateTime::createFromFormat('Y-m-d',$lastDateStr);
		date_add($dateEnd,date_interval_create_from_date_string("280 days"));

		$interval = DateInterval::createFromDateString("7 days");
		$period = new DatePeriod($dateStart,$interval,$dateEnd);

		$RotDatesArr = array();
		$counter = 1;
		foreach ($period as $date) {
			$RotDatesArr[$counter] = $date;
			$counter++;
		}


		$dateHolidayStart = $dateStart;
		date_sub($dateHolidayStart,date_interval_create_from_date_string("1 year"));
		$dateHolidayEnd = $dateEnd;
		date_sub($dateHolidayEnd,date_interval_create_from_date_string("1 year"));

		/**
		 * get holidays.. should be calling a new method to be made getHolidays between dates to
		 * get the holidays from the next rotation period from last year.
		 */ 
		$holidays = $this->db->getCongregationsHolidaysForDates(date_format($dateHolidayStart, 'Y-m-d'),date_format($dateHolidayEnd, 'Y-m-d'));
		$holidayArr = array();
		if(!empty($holidays)){
			foreach ($holidays as $holiday) {
				$holidayArr[$holiday['date']] = $holiday['last_congregation'];
			}
		}

		//fill in posibility array(matrix)
		// - it needs to take into consideration past rotations in order to create the array
		$possibilitiesArr = array();
		for($i=1; $i<=count($RotDatesArr);$i++){
			$curDate = $RotDatesArr[$i]->format('Y-m-d');
			$blackOutCongs = "";
			foreach($blackoutArr as $blackoutCong => $date){
				if($date != $curDate){
					$blackOutCongs .= "$blackoutCong,";
				}
			}
			$holidayCongs = array();
			foreach ($holidayArr as $hDate => $hCong) {
				if($curDate == $hDate){
					$holidayCongs[] = $hCong;
				}
			}
			print_r($holidayCongs);
			if(!empty($holidayCongs)){
				$newCongs = "";
				foreach ($holidayCongs as $cong) {
					$pattern = "/(^|\D)".$cong."(\D|$)/";
					$newCongs = preg_replace($pattern,',',$blackOutCongs);
					print_r($newCongs);
				}
				$newHolidayCongs = trim($newCongs,',');
				$possibilitiesArr[$i] = $newHolidayCongs;
			}
			else{
				$possibilitiesArr[$i] = $blackOutCongs;
			}
		}

		$numberOfWeeks = 13;
		$numberOfCongregations = 13;
		$numberOfRotationsAtATime = 3;

		$counter = 1;
		// go through the possible schedule array and randomly select congregations for dates.
		$possibilitiesArrCopy = $possibilitiesArr;
		$possibleScheduleRot1 = array();
		$possibleScheduleRot2 = array();
		$possibleScheduleRot3 = array();
		foreach ($possibilitiesArrCopy as $rotNumber => $congsAvailable) {
			
			$search = 0;
			$num = 0;
			$radomNumber = 0;
			$randomSelection = 0;
			while(getType($search) == "integer"){
				$test = explode(',', $congsAvailable);
				array_splice($test, 13); // removing the empty element
				$num = count($test);
				$radomNumber = rand(0,($num-1));
				$randomSelection = $test[$radomNumber];
				//check number is not repeating within possibleSchedule before deleting
				if($counter == 1){
					$search = array_search($randomSelection,array_column($possibleScheduleRot1,'congregation'));
				}
				else if ($counter == 2) {
					$search = array_search($randomSelection,array_column($possibleScheduleRot2,'congregation'));
				}
				else{
					$search = array_search($randomSelection,array_column($possibleScheduleRot3,'congregation'));
				}
			}

				// add to possibilityArr
			if($counter == 1){
				$possibleScheduleRot1[$rotNumber] = array("date" => $RotDatesArr[$rotNumber],
												  "congregation" => $randomSelection);
			}
			else if ($counter == 2) {
				$possibleScheduleRot2[$rotNumber] = array("date" => $RotDatesArr[$rotNumber],
												  "congregation" => $randomSelection);
			}
			else{
				$possibleScheduleRot3[$rotNumber] = array("date" => $RotDatesArr[$rotNumber],
												  "congregation" => $randomSelection);
			}

			//deleting selection
			for ($i=1; $i <= ($numberOfWeeks*$counter); $i++) { 
				$oldVal = $possibilitiesArrCopy[$i];
				$pattern = "/(^|\D)".$randomSelection."(\D|$)/";
				$newVal = preg_replace($pattern,',',$oldVal);
				$possibilitiesArrCopy[$i] = trim($newVal,',');
			}

			if($rotNumber%13 == 0){
				$counter ++;
			}
		}

		$possibleSchedule = array(($lastRotID+1)=>$possibleScheduleRot1, ($lastRotID+2)=>$possibleScheduleRot2, ($lastRotID+3)=>$possibleScheduleRot3);


		foreach ($possibleSchedule as $rotation => $rot) {
			foreach ($rot as $r => $info) {

				$rotationToDate = DateTime::createFromFormat('Y-m-d',date_format($info['date'], 'Y-m-d'));
				date_add($rotationToDate,date_interval_create_from_date_string("6 days"));

				if($r > 13 && $r < 27){
					$fixedR = $r-13;
					$this->db->insertNewRotation($rotation,$fixedR,$info['congregation'],date_format($info['date'],'Y-m-d'),date_format($rotationToDate,'Y-m-d'));
				}
				else if($r >=27){
					$fixedR = $r-26;
					$this->db->insertNewRotation($rotation,$fixedR,$info['congregation'],date_format($info['date'],'Y-m-d'),date_format($rotationToDate,'Y-m-d'));
				}
				else{
					$this->db->insertNewRotation($rotation,$r,$info['congregation'],date_format($info['date'],'Y-m-d'),date_format($rotationToDate,'Y-m-d'));
				}
			}
		}
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
					<td>" . $name ." <div class='tb-container'> <a href='admin_edit_". $this->getType($type, ['cong', 'bus','user']) . ".php?" . $this->getType($type, ['congregation', 'driver', 'user']) . "=" . $id ."'>\n
									 	<input type='button' class='tb' name='" . $name . "' value='Edit'>\n
									 </a>\n

									 <a class='anchor' href=''>\n
									 	<input type='button' class='delete-btn tb tb-delete' data-id='".$id ."' data-type='". $type."' data-name='".$name."' name='delete-".$name."' value='Delete'>\n
									 </a>\n

									 <a href='../email.php?uid=".$id."&type=".$type."'>\n
									 	<input type='button' class='tb' id='email-btn' name='email-".$name."' value='Email'>\n

									 </a>\n

									 <a class='anchor' href=''>\n
									 	<input type='button' class='reset-btn tb' data-id='".$id ."' data-type='". $type."' value='Reset Password'>\n
									 </a></div>\n
					</td>

				</tr>";
	}	

	/**
	 * Helper function to retreive the type of 
	 * account.
	 * 
	 * @param  [string] $type [c, d, or u]
	 * @param  [string array] [ cong, bus, user]
	 * @return [string]       [returns cong, bus, or user]
	 */
	private function getType($type, $stringType){

		switch($type){
			case 'c':
				return $stringType[0];
			case 'd':
				return $stringType[1];
			case 'u':
				return $stringType[2];
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