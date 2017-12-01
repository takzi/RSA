<?php
date_default_timezone_set('UTC');
/**
 * Containers functions that are used
 * on most if not all pages in the RSA.
 *
 *
 * @author     Kristen Merritt
 * @author     Tiandre Turner
 * @author     Chevy Mac
 * @version    Release: 1.0
 * @date       11/26/2017
 */

class GeneralTemplate {
	private $page;         // name of the page
	private $path_to_root; // path to public_html root

	/**
	 * Constructor for GeneralTemplate.
	 * 
	 * @param string $page         page name
	 * @param string $path_to_root path to public_html
	 */
	public function __construct($page, $path_to_root){
		$this->path_to_root = $path_to_root;
		$this->page = $page;

	}

	/**
	 * Inserts the header onto the page.
	 * 
	 * @return string html of the header
	 */
	function insertHeader(){
		$logout = "<li><a href='".$this->path_to_root."index.php'>Login</a></li>\n";
		if(isset($_SESSION['id'])) { // login or logout button decision
			$logout = "<li><a href='".$this->path_to_root."templates/logout.php'>Logout</a></li>\n"; 
		}

		return "<!DOCTYPE html>\n
				<html lang='en'>\n
				<head>\n
					<meta charset='utf-8' />\n
					<meta name='viewport' content='width=device-width, initial-scale=1' />\n
					<title>".$this->page."</title>\n
					<script src='".$this->path_to_root."js/jquery-3.2.1.min.js' type='text/javascript'></script>\n
					<link href='".$this->path_to_root."css/default.css' rel='stylesheet'>\n
					<script src='".$this->path_to_root."js/default.js' type='text/javascript'></script>\n
				</head>\n
					<body>\n
						<div id='header'>\n
							<div id='logo_container'>\n
								<img src='".$this->path_to_root."img/logo.png' alt='RAIHN Logo' class='logo'>\n
							</div>\n
							<nav>\n
								<ul class='clearfix'>\n
									<li><a href='".$this->path_to_root."index.php'>Home</a></li>\n
									<li id='scheduleNav'><a href='#''>Schedules</a>\n
										<ul id='hidden_nav'>\n
											<li><a href='".$this->path_to_root."templates/congregation_schedule.php'>Congregation Schedule</a></li>\n
											<li><a href='".$this->path_to_root."templates/bus_driver_schedule.php'>Bus Driver Schedule</a></li>\n
										</ul>\n
									</li>\n
									<li><a href='".$this->path_to_root."templates/profile.php'>Profile</a></li>\n
									<li><a href='http://raihn.org'>raihn.org</a></li>\n
									".$logout."
								</ul>\n
							</nav>\n
						</div>\n
						<div id='container'>\n
							<div id='main_content'>\n";
	}

	/**
	 * Inserts the footer onto the page.
	 * 
	 * @return string footer html
	 */
	function insertFooter(){
		return 	"</div> <!-- end main_content -->\n
				<footer id='footer'>\n
					<div id='footer_container'>\n
						<section id='RSA' class='footer_section'>\n
							<h1 style='border: none;'> RSA </h1>\n
						</section>\n
						<section id='links' class='footer_section'>\n
							<article id='links_1'>\n
								<ul>\n
									<li><a href='".$this->path_to_root."index.php'>Login</a></li>\n
									<li><a href='".$this->path_to_root."templates/bus_driver_schedule.php'>Drivers</a></li>\n
									<li><a href='".$this->path_to_root."templates/congregation_schedule.php'>Congregations</a></li>\n
								</ul>\n
							</article>\n
							<article id='links_2'>\n
								<ul>\n
									<li><a href='#'>About</a></li>\n
									<li><a href='https://www.facebook.com/RochesterAreaInterfaithHospitalityNetwork'>Facebook</a></li>\n
									<li><a href='https://twitter.com/raihnshelter'>Twitter</a></li>\n
								</ul>\n
							</article>\n
							<article id='links_3'>\n
								<ul>\n
									<li><a href='http://www.raihn.org/financial-support'>Donate</a></li>\n
									<li><a href='http://www.raihn.org'>raihn.org</a></li>\n
									<li><a href='https://www.rit.edu''>rit.edu</a></li>\n
								</ul>\n
							</article>\n
						</section>\n
						<section id='RIT' class='footer_section'>\n
							<h1 style='border: none;'> RIT </h1>\n
						</section>\n
					</div>\n
				</footer>\n
			</div> <!-- end container -->\n
			</body>\n
		</html>\n";
	}

	/**
	 * Inserts the login form onto the page.
	 * 
	 * @return string login form html
	 */
	function insertLoginForm(){
	return "<link href='".$this->path_to_root."css/login.css' rel='stylesheet'>\n
			<div class='form_header clearfix'>\n
					<h1>RSA Login</h1>\n
				</div>\n
			<form id='login_form' method='POST'>\n
				<input type='text' placeholder='email' name='email' required>\n
				<br><br>
				<input type='password' placeholder='password' name='password' required>\n
				<br><br>
				<button type='submit'>Login</button>\n
				<a id='request_href' href='templates/request_account.php'>Request Account</a>\n
			</form>";
	}

	/**
	 * Inserts the create account form
	 * onto the page.
	 * 
	 * @return string html of form
	 */
	function insertCreateAccountForm(){
		return "<link href='".$this->path_to_root."css/request_account_form.css' type='text/css' rel='stylesheet'>\n
				<h1 id='title'> Request Account </h1>\n
				<form id='request_account_form' method='POST'>\n
					<input id='fname' type='text' placeholder='first name' name='fname' required>\n
					<br>
					<input id='lname' type='text' placeholder='last name' name='lname' required>\n
					<br>
					<input id='email' type='text' placeholder='email' name='email' required>\n
					<br>
					<input id='pass' type='password' placeholder='password' name='password' required>\n
					<br>
					<input id='confirmpass' type='password' placeholder='confirm password' name='confirmpassword' required>\n
					<div id='confirmed' class='hide'>Password are not matched.</div>\n
					<br>
					<select id='role' name='role'>\n
						<option value='-1'>Select a Role</option>\n
						<option value='5'>Bus Driver</option>\n
						<option value='4'>Congregation Leader</option>\n
					</select>\n
					<br>
					<input id='congName' class='hide' type='text' placeholder='Congregation Name' name='congName'>\n
					<input id='contactNum' class='hide' type='tel' placeholder='Phone Number' name='contactNum'>\n
					<br>
					<button type='submit'>Request Account</button>\n
				</form>\n
				<script type='text/javascript' src='".$this->path_to_root."js/request_account.js'></script>";
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
		require_once('admin/AdminFunctions.class.php');
		$adminFunctions = new AdminFunctions($this->page, $this->path_to_root);
		$adminFunctions->updatePassword($_id,$_fName, $_lName, $_roleID, $_email, $_password);
	}
}

?>