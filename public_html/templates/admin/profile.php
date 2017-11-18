<?php
	/**
	 * Admin Profile page for RSA
	 * 
	 * @author     Chevy Mac 
	 * @author     Kristen Merritt
	 * @version    Release: 1.0
	 * @date       11/16/17
	 */
	 
	$page='RAHIN Admin Profile';
	$path_to_root="./../../";
	
	// Starting the session
	session_start();
	
	// Setting up template system and loads functions for Admin
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');

	$generalTemplate = new GeneralTemplate($page, $path_to_root);
	$adminFunctions = new AdminFunctions($page, $path_to_root);
	
	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/admin.css" rel="stylesheet">';
	
	// Checks if account has admin privilege, and if it does, inserts admin profile.
	if(isset($_SESSION['id']) && isset($_SESSION['fullname']) && isset($_SESSION['role'])){
		$role = $_SESSION['role'];
		$fullname = $_SESSION['fullname'];

		if($role == 1 || $role == 2 || $role == 3){ 
			echo $adminFunctions->insertAdminHome($fullname, $role);
		} else {
			echo "<h1 class='message'> Please log in with an admin account. </h1>";
		}		
	} else {
		echo "<h1 class='message'>Please log in to access your profile.</h1>";
	}

	echo $generalTemplate->insertFooter(); 

?>

<!-- Admin 1
Congregation scheduler 2
Bus driver scheduler 3
Congregation leader 4
Bus driver 5 -->