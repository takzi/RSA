<?php
	$page='RAHIN Admin Bus Drivers';
	$path_to_root="./../../";

	session_start();

	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');

	$generalTemplate = new GeneralTemplate($page, $path_to_root);
	$adminFunctions = new AdminFunctions($page, $path_to_root);

	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/admin.css" rel="stylesheet">';

	if(isset($_SESSION['id']) && isset($_SESSION['fullname']) && isset($_SESSION['role'])){
		if($_SESSION['role'] == 1 || $_SESSION['role'] == 3){
			echo $adminFunctions->insertCongBusAdmin("Bus Drivers");
			echo $adminFunctions->insertBusDriversIntoAdminPage();
		} else {
			echo "<h1> Please log into an appropriate account. </h1>";
		}		
	} else {
		echo "<h1> Please log in. </h1>";
	}

	echo $generalTemplate->insertFooter();
?>