<?php
	$page='RAHIN Admin Congregation';
	$path_to_root="./../../";

	session_start();

	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');

	$generalTemplate = new GeneralTemplate($page, $path_to_root);
	$adminFunctions = new AdminFunctions($page, $path_to_root);

	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/admin.css" rel="stylesheet">';

	if(isset($_SESSION['id']) && isset($_SESSION['fullname']) && isset($_SESSION['role'])){
		echo $adminFunctions->insertCongAdmin();
		echo $adminFunctions->insertCongregationsIntoAdminPage();
	} else {
		echo "<h1> Please log in. </h1>";
	}

	echo $generalTemplate->insertFooter();
?>