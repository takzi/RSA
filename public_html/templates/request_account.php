<?php
	$page='RAHIN Home';
	$path_to_root="./";
	require_once($path_to_root.'templates/header.php');

	session_start(); 

	if(!empty($_POST['fname']) && !empty($_POST['lname']) && !empty($_POST['email']) && !empty($_POST['password'])) {
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$role = $_POST['role'];

		// Checking to make sure we have a valid email address
		if(validateEmail($email)){
			if($role != "default"){
				require_once($path_to_root.'../model/DB.class.php');
				require_once($path_to_root.'../BUS/request_account.php');
				
				$db = new DB();
						
				// Checking to make sure the email is not already used
				if(checkUniqueEmail($db, $email)){
					$roleId = -1;

					switch($role){
						case "admin": $roleId = 0; break;
						case "bus_driver": $roleId = 2; break;
						case "congregation": $roleId = 3; break;
					}

					if($roleId != -1){
						// Create new account
						createNewAccount($db, $fname, $lname, $roleId, $email, $password);
						// redirect upon success
						header("Location: http://team-red.ist.rit.edu/~km2029/");
					} else {
						echo '<script>alert("Invalid role selected.");</script>';
					}				
				} else {
					echo '<script>alert("Email already in use");</script>';
				}
			} else {
				echo '<script>alert("Please select a role.");</script>';
			}
		} else {
			echo '<script>alert("Invalid email provided");</script>';
		}
	}
?>
	<link href="<?php echo $path_to_root.'css/request_account_form.css'?>" type="text/css" rel="stylesheet">

	<h1 id="title"> Request Account </h1>
	<form id="request_account_form" method="POST">
		<input id="fname" type="text" placeholder="first name" name="fname" required>
		<br>
		<input id="lname" type="text" placeholder="last name" name="lname" required>
		<br>
		<input id="email" type="text" placeholder="email" name="email" required>
		<br>
		<input id="pass" type="password" placeholder="password" name="password" required>
		<br>
		<select id="role" name="role">
			<option value="default">Select a Role</option>
			<option value="bus_driver">Bus Driver</option>
			<option value="congregation">Congregation</option>
			<option value="admin">Admin</option>
		</select>
		<br>
		<button type="submit">Request Account</button>
	</form>

<?php
	require_once($path_to_root.'templates/footer.php');
?>