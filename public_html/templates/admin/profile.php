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
		$role = $_SESSION['role'];
		$fullname = $_SESSION['fullname'];
		
		if($role == 1 || $role == 2 || $role == 3){ 
			echo $adminFunctions->insertAdminHome($fullname, $role);
		} else {
			echo "<h1> Please log in with an admin account. </h1>";
		}		
	} else {
		echo "<h1>Please log in to access your profile.</h1>";
	}

	echo $generalTemplate->insertFooter(); 

?>

<!-- Admin 1
Congregation scheduler 2
Bus driver scheduler 3
Congregation leader 4
Bus driver 5 -->