<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo $page; ?></title>
	<link href="<?php echo $path_to_root; ?>css/default.css" rel="stylesheet">
	<script src="<?php echo $path_to_root; ?>js/default.js" type="text/javascript"></script>
</head>
	<?php require_once($path_to_root.'../BUS/sanitation_validation.php') ?>
	<body>
		<div id="header">
			<div id="logo_container">
				<img src="<?php echo $path_to_root ?>img/logo.png" alt="RAIHN Logo" class="logo">
			</div>
			<nav>
				<ul class="clearfix">
					<li><a href="<?php echo $path_to_root.'index.php' ?>">Home</a></li>
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
			<div id="main_content"> 
			