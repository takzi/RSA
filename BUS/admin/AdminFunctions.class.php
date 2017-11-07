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
		return "<table id='congregations'>
				<tr>
					<td>Congregation 1 <input type='button' id='tb-right' name='Congregation 1' value='Edit'><input type='button' value='Reset Password'></td>
				</tr>
				<tr>
					<td>Congregation 2 <input type='button' id='tb-right' name='Congregation 2' value='Edit'><input type='button' value='Reset Password'></td>
				</tr>
				<tr>
					<td>Congregation 3 <input type='button' id='tb-right' name='Congregation 3' value='Edit'><input type='button' value='Reset Password'></td>
				</tr> 
				<tr>
					<td>Congregation 4 <input type='button' id='tb-right' name='Congregation 4' value='Edit'><input type='button' value='Reset Password'></td>
				</tr>
				<tr>
					<td>Congregation 5 <input type='button' id='tb-right' name='Congregation 5' value='Edit'><input type='button' value='Reset Password'></td>
				</tr>   
			</table>";
	}

	function insertBusDriversIntoAdminPage(){
		// CREATE THE STRING BASED OFF OF DATA FROM THE DATABASE
		// GET ALL OF THE BUS DRIVERS AND OUTPUT THEM AS DISPLAYED BELOW
		return "<table id='congregations'>
				<tr>
					<td>Bus Driver 1 <input type='button' id='tb-right' name='Bus Driver 1' value='Edit'><input type='button' value='Reset Password'></td>
				</tr>
				<tr>
					<td>Bus Driver 2 <input type='button' id='tb-right' name='Bus Driver 2' value='Edit'><input type='button' value='Reset Password'></td>
				</tr>
				<tr>
					<td>Bus Driver 3 <input type='button' id='tb-right' name='Bus Driver 3' value='Edit'><input type='button' value='Reset Password'></td>
				</tr> 
				<tr>
					<td>Bus Driver 4 <input type='button' id='tb-right' name='Bus Driver 4' value='Edit'><input type='button' value='Reset Password'></td>
				</tr>
				<tr>
					<td>Bus Driver 5 <input type='button' id='tb-right' name='Bus Driver 5' value='Edit'><input type='button' value='Reset Password'></td>
				</tr>   
			</table>";
	}
}


?>