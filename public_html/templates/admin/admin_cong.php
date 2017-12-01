<?php
	/**
	 * Admin Congregation Driver page for RSA
	 * 
	 * @author     Chevy Mac	 
	 * @author     Kristen Merritt
	 * @version    Release: 1.0
	 * @date       11/9/17
	 */
	 
	$page='RAIHN Admin Congregation';
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
	
	// If admin's role is allowed for Congregation, inserts Admin Congregation into page
	if(isset($_SESSION['id']) && isset($_SESSION['fullname']) && isset($_SESSION['role'])){
		if($_SESSION['role'] == 1 || $_SESSION['role'] == 2){
			echo $adminFunctions->insertCongBusAdmin("Congregations");
			echo $adminFunctions->insertCongregationsIntoAdminPage();
		} else {
			echo "<h1> Please log into an appropriate account. </h1>";
		}		
		
	} else {
		echo "<h1> Please log in. </h1>";
	}

	echo $generalTemplate->insertFooter();
?>