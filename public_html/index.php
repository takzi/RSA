<?php
	/**
	 * Home / Index page for RSA
	 * 
	 * @author     Original Author: Kristen Merritt
	 * @version    Release: 1.0
	 * @date       10/21/17
	 */

	$page='RAHIN Home';
	$path_to_root="./";

	// Setting template system
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	$generalTemplate = new GeneralTemplate($page, $path_to_root);

	// Starting the session
	session_start();

	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();

	// Checking to see if any session is currently active
	if(isset($_SESSION['fullname']) && isset($_SESSION['id']) && isset($_SESSION['role'])){
		echo "<h1 class='message'> Welcome ".$_SESSION['fullname']."</h1>";
		echo "<h2 class='message'> Access your profile, schedules, and more using the navigation above. </h2>";
	} else if(!empty($_POST['email']) && !empty($_POST['password'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		require_once($path_to_root.'../BUS/login/LoginChecker.class.php');
		$loginChecker = new LoginChecker($path_to_root);

		if($loginChecker->attemptLogin($email, $password)){
			$_SESSION['id'] = $loginChecker->getUserId();
			$_SESSION['first'] = $loginChecker->getFirstName();
			$_SESSION['last'] = $loginChecker->getLastName();
			$_SESSION['email'] = $loginChecker->getEmail();
			$_SESSION['role'] = $loginChecker->getRole();
			$_SESSION['fullname'] = $_SESSION['first'] . ' ' . $_SESSION['last'];

			header("Location:".$path_to_root."/index.php");
		} else {
			echo '<script>alert("Invalid login attempt.");</script>';
			echo $generalTemplate->insertLoginForm();
		} 
	} else {
		echo $generalTemplate->insertLoginForm();
	}
	echo $generalTemplate->insertFooter();
?>