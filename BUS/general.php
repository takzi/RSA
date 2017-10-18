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

function insertHeader(){
	echo '<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo $page; ?></title>
		<link href="<?php echo $path_to_root; ?>css/default.css" rel="stylesheet">
		<script src="<?php echo $path_to_root; ?>js/default.js" type="text/javascript"></script>
	</head>
		<?php require_once($path_to_root.\'../BUS/sanitation_validation.php\') ?>
		<body>
			<div id="header">
				<div id="logo_container">
					<img src="<?php echo $path_to_root ?>img/logo.png" alt="RAIHN Logo" class="logo">
				</div>
				<nav>
					<ul class="clearfix">
						<li><a href="<?php echo $path_to_root.\'index.php\' ?>">Home</a></li>
						<li><a href="#">Schedules</a>
							<ul id="hidden_nav">
								<li><a href="#">Congregation Schedule</a></li>
								<li><a href="#">Bus Driver Schedule</a></li>
							</ul>
						</li>
						<li><a href="#">Profile</a></li>
						<li><a href="http://www.raihn.org/">raihn.org</a></li>
					</ul>
				</nav>
			</div>
			<div id="container">
				<div id="main_content">';
}

function insertFooter(){
	echo 	'</div> <!-- end main_content -->
			<footer id="footer">
				<div id="footer_container">
					<section id="RSA" class="footer_section">
						<h1> RSA </h1>
					</section>
					<section id="links" class="footer_section">
						<article id="links_1">
							<ul>
								<li><a href="#">Contact</a></li>
								<li><a href="#">Login</a></li>
								<li><a href="#">Facebook</a></li>
							</ul>
						</article>
						<article id="links_2">
							<ul>
								<li><a href="#">About</a></li>
								<li><a href="#">Schedules</a></li>
								<li><a href="#">Twitter</a></li>
							</ul>
						</article>
						<article id="links_3">
							<ul>
								<li><a href="#">Help</a></li>
								<li><a href="#">raihn.org</a></li>
								<li><a href="#">rit.edu</a></li>
							</ul>
						</article>
					</section>
					<section id="RIT" class="footer_section">
						<h1> RIT </h1>
					</section>
				</div>
			</footer>
		</div> <!-- end container -->
		</body>
	</html>';
}





?>