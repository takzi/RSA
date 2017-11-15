<?php
	$page='Reset Password';
	if($_POST['action'] == 'reset'){
		$path_to_root="./../../";
		require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');

		$adminFunctions = new AdminFunctions($page, $path_to_root);
		$adminFunctions->resetPassword($_POST['type'], $_POST['userId']);
	}
?>