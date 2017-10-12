<?php
	$page='RAHIN Home';
	$path_to_root="./";
	require_once($path_to_root.'templates/header.php');
?>

<?php 
	session_start();

	if(!empty($_SESSION['name']) && !empty($_SESSION['id']) && !empty($_SESSION['role'])){
		// ==========================================================
		// ============== SESSION IS CURRENTLY RUNNING ==============
		// ==========================================================
		
		// TODO: Validate Token?
		
		echo 'Welcome ' . $_SESSION['name'];

	} else if(!empty($_POST['email']) && !empty($_POST['password'])){
		// ==========================================================
		// ========= THEY SUBMITTED A USERNAME AND PASSWORD =========
		// ==========================================================
		
		$email = $_POST['email'];
		$password = $_POST['password'];

		require_once($path_to_root.'../model/DB.class.php');
		$db = new DB();

		require_once($path_to_root.'../BUS/login.php');
		$result = getUserByEmail($db, $email);

		if($result != null){
			if(password_verify($password, $result[5])){
				$_SESSION['id'] = $result[0];
				$_SESSION['first'] = $result[1];
				$_SESSION['last'] = $result[2];
				$_SESSION['email'] = $result[3];
				$_SESSION['role'] = $result[6];

				echo "Welcome " . $_SESSION['name'];
			} else {
				echo '<script>alert("Invalid password.");</script>';
				require_once($path_to_root.'templates/login_form.php');
			}
		} else {
			echo '<script>alert("Invalid email.");</script>';
			require_once($path_to_root.'templates/login_form.php');
		}
	} else {
		require_once($path_to_root.'templates/login_form.php');
	}
?>

<?php
	require_once($path_to_root.'templates/footer.php');
?>