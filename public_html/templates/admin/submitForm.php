<?php
	/**
	 * Submit Page for RSA
	 * 
	 * @author     Tiandre Turner
	 * @version    Release: 1.0
	 * @date       11/28/17
	 */
	 
	$page='Submit data';
	$path_to_root="./../../";
	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');

	$adminFunctions = new AdminFunctions($page, $path_to_root);
	// If action is selected for reset, loads admin function and proceeds with resetting password for user.
	if($_POST['action'] == 'submitBlackoutDates'){
		$adminFunctions->insertBlackoutDatesIntoDB($_POST['congID'], $_POST['from'], $_POST['to']);
	}elseif($_POST['action'] == 'submitAvailablity'){

	}
?>