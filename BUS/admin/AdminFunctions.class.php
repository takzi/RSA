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
			$buttons = "<a href='#'><div class='admin_home_button'>Bus Drivers</div></a>\n
							<a href='admin_cong.php'><div class='admin_home_button'>Congregations</div></a>\n";
		} elseif($role == 2){
			$buttons = "<a href='admin_cong.php'><div class='admin_home_button'>Congregations</div></a>\n";
		} elseif($role == 3){
			$buttons = "<a href='#'><div class='admin_home_button'>Bus Drivers</div></a>\n";
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
}


?>