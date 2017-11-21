<?php
	/**
	 * Reset Page for RSA
	 * 
	 * @author     Tiandre Turner
	 * @version    Release: 1.0
	 * @date       11/15/17
	 */
	 
	$page='Reset Password';
	
	// If action is selected for reset, loads admin function and proceeds with resetting password for user.
	if($_POST['action'] == 'reset'){
		$path_to_root="./../../";
		require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');

		$adminFunctions = new AdminFunctions($page, $path_to_root);
		$adminFunctions->resetPassword($_POST['type'], $_POST['userId']);
	}
?>