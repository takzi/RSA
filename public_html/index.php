<?php
	$page='RAHIN Home';
	$path_to_root="./";

	// ==========================================================
	// ============== SETTING TEMPLATE SYSTEM ===================
	// ==========================================================
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	$generalTemplate = new GeneralTemplate($page, $path_to_root);

	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();

	// Starting the session
	session_start();

	// Checking to see if any session is currently active
	if(isset($_SESSION['fullname']) && isset($_SESSION['id']) && isset($_SESSION['role'])){
		// ==========================================================
		// ============== SESSION IS CURRENTLY RUNNING ==============
		// ==========================================================
	} else if(!empty($_POST['email']) && !empty($_POST['password'])){
		// ==========================================================
		// ========= THEY SUBMITTED A USERNAME AND PASSWORD =========
		// ==========================================================
		
		$email = $_POST['email'];
		$password = $_POST['password'];

		require_once($path_to_root.'../BUS/login.php');
		$loginChecker = new LoginChecker($path_to_root);

		if($loginChecker->attemptLogin($email, $password)){
			$_SESSION['id'] = $loginChecker->getUserId();
			$_SESSION['first'] = $loginChecker->getFirstName();
			$_SESSION['last'] = $loginChecker->getLastName();
			$_SESSION['email'] = $loginChecker->getEmail();
			$_SESSION['role'] = $loginChecker->getRole();
			$_SESSION['fullname'] = $_SESSION['first'] . ' ' . $_SESSION['last'];
			echo "Welcome " . $_SESSION['fullname'];
		} else {
			echo '<script>alert("Invalid login attempt.");</script>';
			echo $generalTemplate->insertLoginForm();
		} 
	} else {
		echo $generalTemplate->insertLoginForm();
	}


	echo $generalTemplate->insertFooter();
?>