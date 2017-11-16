<?php
	$page='RAHIN Profile';
	$path_to_root="./../";

	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	$generalTemplate = new GeneralTemplate($page, $path_to_root);

	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/profile.css" rel="stylesheet">';
	session_start();

	if(isset($_SESSION['fullname']) && isset($_SESSION['id']) && isset($_SESSION['role'])){
		$role = $_SESSION['role'];			

		if($role == 1 || $role == 2 || $role == 3){
			Header("Location:".$path_to_root."/templates/admin/profile.php");
		} elseif($role == 4){
			require_once($path_to_root.'templates/congregation/profile.php');
		} elseif($role == 5){
			require_once($path_to_root.'templates/bus_driver/profile.php');
		} else {
			echo "Unknown account. Please log in again.";
		}
	} else {
		echo "<h1>Please log in.</h1>";
	}
	
	echo $generalTemplate->insertFooter();
?>