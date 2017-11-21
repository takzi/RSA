<?php
	/**
	 * Request Account for RSA
	 * 
	 * @author     Kristen Merritt
	 * @author     Tiandre Turner
	 * @version    Release: 1.0
	 * @date       11/15/17
	 */
	 
	$page='Request Account';
	$path_to_root="./../";

	// Setting up template system
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	$generalTemplate = new GeneralTemplate($page, $path_to_root);
	
	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();
	
	// Starting the session
	session_start(); 

	//echo "<script>alert('".$_POST['fname']."')</script>";
	
	// Checks if the fields aren't empty before proceeding creating account.
	if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirmpassword'])) {
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirmpassword'];
		$role = $_POST['role'];
		$contactNum = $_POST['contactNum'];
		$congName = $_POST['congName'];

		require_once($path_to_root.'../BUS/login/AccountCreator.class.php');
		$accountCreator = new AccountCreator($path_to_root);

		$responseMessage = $accountCreator->createNewAccount($fname, $lname, $role, $email, $password, $confirmPassword, $contactNum, $congName);
		echo "<script>alert('".$responseMessage."')</script>";
	}
	
	// Inserting form for create account
	echo $generalTemplate->insertCreateAccountForm();

	echo $generalTemplate->insertFooter();
?>