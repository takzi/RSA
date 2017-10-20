<?php
	$page='Request Account';
	$path_to_root="./../";

	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	$generalTemplate = new GeneralTemplate($page, $path_to_root);

	echo $generalTemplate->insertHeader();

	session_start(); 

	//echo "<script>alert('".$_POST['fname']."')</script>";

	if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$role = $_POST['role'];

		require_once($path_to_root.'../BUS/login/AccountCreator.class.php');
		$accountCreator = new AccountCreator($path_to_root);

		echo "<script>alert('".$accountCreator->createNewAccount($fname, $lname, $role, $email, $password)."')</script>";
	}

	echo $generalTemplate->insertCreateAccountForm();

	echo $generalTemplate->insertFooter();
?>