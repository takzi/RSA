<?php
	$page='RAHIN Home';
	$path="";
	include("templates/header.php");
?>

<?php 
	session_start();

	if(isset($_POST['username']) and isset($_POST['password'])){
		$username = $_POST['username'];
		$password = $_POST['password']; // this should be hashed

		// create query to check username and hashed password
		
		// result = 1 if a user is found, or however else we want to do it
		$result = 0;
		
		if($result == 1){
			// get the role of the person for permissions
			$role = "admin";

			$_SESSION['username'] = $username;
			$_SESSION['role'] = $role;
			echo "Welcome " . $_SESSION['uesrname'];
		} else {
			echo '<script>alert("Invalid login attempt.");</script>';
			include("templates/login_form.php");
		}
	} else {
		include("templates/login_form.php");
	}
?>

<?php
	include("templates/footer.php");
?>