<?php
$path = "./../";
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo $page; ?></title>
	<link href="<?php echo $path; ?>css/default.css" rel="stylesheet">
	<script src="<?php echo $path; ?>js/default.js" type="text/javascript"></script>
</head>
	<body>
		<div id="header">
			<div id="logo_container">
				<img src="../img/logo.png" alt="RAIHN Logo" class="logo">
			</div>
			<nav>
				<ul class="clearfix">
					<li><a href="#">Home</a></li>
					<li><a href="#">Schedules</a>
						<ul id="hidden_nav">
							<li><a href="#">Congregation Schedule</a></li>
							<li><a href="#">Bus Driver Schedule</a></li>
						</ul>
					</li>
					<li><a href="#">raihn.org</a></li>
				</ul>
			</nav>
		</div>
		<div id="container">
			<div id="main_content"> 
			