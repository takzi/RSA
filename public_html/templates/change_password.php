<?php
	/**
	 * Change Password for Current User
	 * 
	 * @author     Kristen Merritt
	 * @author     Tiandre Turner
	 * @author     Chevy Mac
	 * @version    Release: 1.0
	 * @date       12/4/17
	 */
	 
	$page='Change Password';
	$path_to_root="./../";

	// Setting up template system
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');
	
	$generalTemplate = new GeneralTemplate($page, $path_to_root);
	$adminFunctions = new AdminFunctions($page, $path_to_root);
	// Starting the session
	session_start(); 
	
	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/admin.css" rel="stylesheet">';
	echo '<link href="'.$path_to_root.'css/profile.css" rel="stylesheet">';
	echo '<link href="'.$path_to_root.'css/request_account_form.css" rel="stylesheet">';
	
	// Checks if the fields aren't empty before proceeding creating account.
	if( !empty($_POST['currentpassword']) && !empty($_POST['password']) && !empty($_POST['confirmpassword'])) {
		$currentPassword = $_POST['currentpassword'];
		$password = $_POST['password'];
		$confirmPassword = $_POST['confirmpassword'];
		$id = $_SESSION['id'];
		$firstName = $_SESSION['first'];
		$lastName = $_SESSION['last'];
		$email = $_SESSION['email'];
		$role = $_SESSION['role'];

		$user = $adminFunctions->getUser($id)[0];
		
		if(password_verify($currentPassword, $user->getPassword())){
			if($password === $confirmPassword){
				$generalTemplate->updatePassword($id, $firstName, $lastName, $role, $email, $password);
				echo "<script>alert('Password updated')</script>";
			}else{
				echo "<script>alert('Password are not matched')</script>";
			}
		}else{
			echo "<script>alert('The current password is incorrect')</script>";
		}

	}
?>
		<div id="adminLink">
				<a href="profile.php">Profile</a> > <a href="#">Change Password</a>
		</div>
		<h1 id='profile_h1'> Change Password </h1>
			<div id="profile_container">
				<div align="left">
					<a href="profile.php"><button>View Schedule</button></a>
					<br>
					<button>Request Schedule Change</button>
				</div>

				<div align="right">
					<div id="pw_form">
						<form id='change_password_form' method='POST'>
							<br>
							<br>
							<input id='currentpass' type='password' placeholder='Current Password' name='currentpassword' required>
							<br>
							<br>
							<input id='pass' type='password' placeholder='New Password' name='password' required>
							<br>
							<br>
							<input id='confirmpass' type='password' placeholder='Confirm Password' name='confirmpassword' required>
							<div id='confirmed' class='hide'>Password are not matched.</div>
							<br>
							<button type='submit' id='savepw'>Save</button>
						</form>
						<script type='text/javascript' src='<?php echo $path_to_root ?>js/request_account.js'></script>
					</div>
				</div>
			</div>

<?php
	echo $generalTemplate->insertFooter();
?>