<?php

class AdminFunctions{
	private $path_to_root;
	private $db;
	private $sanitizer;

	public function __construct($page, $path_to_root){
		$this->path_to_root = $path_to_root;

		require_once($this->path_to_root.'../model/DB.class.php');
		$this->db = new DB($this->path_to_root);

		require_once($this->path_to_root.'../BUS/Sanitizer.class.php');
		$this->sanitizer = new Sanitizer();
	}

	function insertAdminHome($name, $role){
		$buttons = "";

		if($role == 1){
			$buttons = "<a href='admin_bus.php'><div class='admin_home_button'>Bus Drivers</div></a>\n
							<a href='admin_cong.php'><div class='admin_home_button'>Congregations</div></a>\n";
		} elseif($role == 2){
			$buttons = "<a href='admin_cong.php'><div class='admin_home_button'>Congregations</div></a>\n";
		} elseif($role == 3){
			$buttons = "<a href='admin_bus.php'><div class='admin_home_button'>Bus Drivers</div></a>\n";
		}


		return "<h1 id='profile_h1'>".$name."</h1>\n
					<div id='profile_container' class='clearfix'>\n
						<div id='topButtons' class='clearfix'>\n
							".$buttons."
						</div>\n
						<div id='botButtons' class='clearfix'>\n
							<a href='#'><div class='admin_home_button'>Reports</div></a>\n
							<a href='#'><div class='admin_home_button'>FAQ / Guides</div></a>\n
						</div>\n
					</div>\n";
	}

	function insertCongBusAdmin($type){
		return "<div id='adminLink'>\n
					<a href='".$this->path_to_root."templates/admin/profile.php'>Admin Home</a>\n 
					>
					<a href='#'>".$type."</a>\n
				</div>\n
				<h1>".$type."</h1>\n
				<div id='admin_container'>\n
					<div id='form'>\n
						<input type='text' id='text' name='cong_name' value='Congregation Name'> 
						<input type='button' value='Add Now'>\n
						<input type='button' id='genScheBut' value='Generate New Schedule'>
						<a href='".$this->path_to_root."templates/congregation_schedule.php'><input type='button' value='View Current Schedule'></a>
					</div>";
	}

	function insertCongregationsIntoAdminPage(){
		// CREATE THE STRING BASED OFF OF DATA FROM THE DATABASE
		// GET ALL OF THE CONGREGATIONS AND OUTPUT THEM AS DISPLAYED BELOW
		$congregations = $this->db->getAllCongregations();
		$tr = "";
		foreach($congregations as $congregation){
			$tr .= $this->getHTMLSnippet($congregation->getID(), $congregation->getName(), 'c');
		}
		return "<table id='congregations'>". 
				$tr
			 . "</table>";
	}

	function insertBusDriversIntoAdminPage(){
		// CREATE THE STRING BASED OFF OF DATA FROM THE DATABASE
		// GET ALL OF THE BUS DRIVERS AND OUTPUT THEM AS DISPLAYED BELOW
		$drivers = $this->db->getAllBusDrivers();
		$tr = "";
		foreach($drivers as $driver){
			$contactID = $driver->getContactID();
			$user = $this->db->getUser($contactID)[0];
			$tr .= $this->getHTMLSnippet($contactID, $user->getWholeName(), 'd');
		}
		return "<table id='congregations'>".
				$tr
			.  "</table>";
	}

	private function getHTMLSnippet($id, $name, $type){
		return "<tr>
					<td>" . $name ." <a href='admin_edit_". $this->getType($type, 'cong', 'bus') . ".php?" . $this->getType($type, 'congregation', 'driver') . "=" . $id ."'><input type='button' id='tb-right' name='" . $name . "' value='Edit'></a><input type='button' value='Reset Password'></td>
				</tr>";
	}

	private function getType($type, $cong, $bus){
		return $type == 'c' ? $cong : $bus;
	}

	
	function getCongregation($id){
		return $this->db->getCongregation($id);
	}

	function getBusDriver($id){
		$busDriver = $this->db->getBusDriver($id);
		$busDriverId = $busDriver[0]->getContactID();
		return $this->db->getUser($busDriverId);
	}
}


?>