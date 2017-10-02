<?php
	$page='RAHIN Home';
	$path="";
	include("templates/header.php");
?>

<?php 
	if(isset($_SESSION['username'])){
		echo "Welcome " . $_SESSION['uesrname'];
	} else {
		include("templates/login_form.php");
	}
?>

<?php
	include("templates/footer.php");
?>