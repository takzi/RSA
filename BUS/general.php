<?php
/* 
 * Containers functions that are used
 * on most if not all pages in the RSA.
 *
 * @author     Kristen Merritt
 * @date       10/17/2017
 */


/*
 * ========================================================================
 * ================= HEADER AND FOOTER FUNCTIONS ==========================
 * ========================================================================
 */


class GeneralTemplate {
	private $page;
	private $path_to_root;

	public function __construct($page, $path_to_root){
		$this->$path_to_root = $path_to_root;
		$this->$page = $page;
	}

	function insertHeader(){
		return "<!DOCTYPE html>\n
		<html lang='en'>\n
		<head>\n
			<meta charset='utf-8' />\n
			<title>".$this->page."</title>\n
			<link href='".$this->path_to_root."css/default.css' rel='stylesheet'>\n
			<script src='".$this->path_to_root."js/default.js' type='text/javascript'></script>\n
		</head>\n
			<?php require_once('".$this->path_to_root."../BUS/sanitation_validation.php\') ?>\n
			<body>\n
				<div id='header'>\n
					<div id='logo_container'>\n
						<img src='".$this->path_to_root."img/logo.png' alt='RAIHN Logo' class='logo'>\n
					</div>\n
					<nav>\n
						<ul class='clearfix'>\n
							<li><a href='".$this->path_to_root."index.php\'>Home</a></li>\n
							<li><a href='#''>Schedules</a>\n
								<ul id='hidden_nav'>\n
									<li><a href='#'>Congregation Schedule</a></li>\n
									<li><a href='#'>Bus Driver Schedule</a></li>\n
								</ul>\n
							</li>\n
							<li><a href='#'>Profile</a></li>\n
							<li><a href='http://www.raihn.org/'>raihn.org</a></li>\n
						</ul>\n
					</nav>\n
				</div>\n
				<div id='container'>\n
					<div id='main_content'>\n";
	}

	function insertFooter(){
		echo 	"</div> <!-- end main_content -->\n
				<footer id='footer'>\n
					<div id='footer_container'>\n
						<section id='RSA' class='footer_section'>\n
							<h1> RSA </h1>\n
						</section>\n
						<section id='links' class='footer_section'>\n
							<article id='links_1'>\n
								<ul>\n
									<li><a href='#'>Contact</a></li>\n
									<li><a href='#'>Login</a></li>\n
									<li><a href='#'>Facebook</a></li>\n
								</ul>\n
							</article>\n
							<article id='links_2'>\n
								<ul>\n
									<li><a href='#'>About</a></li>\n
									<li><a href='#'>Schedules</a></li>\n
									<li><a href='#'>Twitter</a></li>\n
								</ul>\n
							</article>\n
							<article id='links_3'>\n
								<ul>\n
									<li><a href='#'>Help</a></li>\n
									<li><a href='#'>raihn.org</a></li>\n
									<li><a href='#''>rit.edu</a></li>\n
								</ul>\n
							</article>\n
						</section>\n
						<section id='RIT' class='footer_section'>\n
							<h1> RIT </h1>\n
						</section>\n
					</div>\n
				</footer>\n
			</div> <!-- end container -->\n
			</body>\n
		</html>\n";
	}

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
			<a id='request_href' href='request_account.php'>Request Account</a>\n
		</form>";
	}
}

?>