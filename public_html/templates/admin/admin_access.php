<?php
	$page='RAIHN Admin Access';
	$path_to_root="./../../";
 	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');
 	require_once($path_to_root.'../BUS/login/AccountCreator.class.php');
 	// require_once($path_to_root. '../BUS/schedule/generate_congregations_schedule.php');
 	// require_once($path_to_root. '../BUS/schedule/generate_bus_driver_schedule.php');
 	
if(isset($_POST['action'])){
		$adminFunctions = new AdminFunctions($page, $path_to_root);
	
		$action = $_POST['action'];

		switch ($action) {
			case 'generateCongregationSchedule':
				$generalCongSchedule = $adminFunctions->generateCongregationSchedule();
				break;

			case 'generateBusDriverSchedule':
				$generalBusSchedule = $adminFunctions->generateBusDriverSchedule(); 
				break;

			case 'updateCongregation':
				$adminFunctions->updateCongregation($_POST['congID'], $_POST['leaderID'], $_POST['cong'], $_POST['leader']);
				$data = "Updating Congregation";
				print_r($data);
				break;
			
			case 'updateBusDriver':
				$adminFunctions->updateBusDriver($_POST['id'], $_POST['name'], $_POST['contactNum']);
				$data = "Updating Driver";
				print_r($data);
				break;

			case 'addBusDriver':
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$email = $_POST['email'];
				$password = "raihn123";
				$role = 5;
				$contactNum = $_POST['contact'];
				$congName = "";

				$accountCreator = new AccountCreator($path_to_root);

				$responseMessage = $accountCreator->createNewAccount($fname, $lname, $role, $email, $password, $password, $contactNum, $congName);
				if($responseMessage == "Account created"){
					$responseMessage = "Added Driver";
				}

				print_r($responseMessage);
				//$adminFunctions->updateBusDriver($_POST['id'], $_POST['name'], $_POST['contactNum']);

				break;

			case 'submitBlackoutDates':
				// If action is selected for reset, loads admin function and proceeds with resetting password for user.
				$adminFunctions->insertBlackoutDatesIntoDB($_POST['congID'], $_POST['from'], $_POST['to']);
				break;

			case 'submitAvailabilityDates':
				// If action is selected for reset, loads admin function and proceeds with resetting password for user.
				$adminFunctions->insertAvailabilityDatesIntoDB($_POST['busID'], $_POST['availabilityDate'], $_POST['timeOfDay']);
				break;

			case 'reset':
				$adminFunctions->resetPassword($_POST['type'], $_POST['userId']);
				$data = "Password Reset";
				print_r($data);
				break;

			case 'delete':
				$data = $adminFunctions->delete($_POST['type'], $_POST['id'], $_POST['name']);
				//$data = "Delete this fool";

				print_r($data);
				break;

			case 'save':
				$user = $adminFunctions->getUser($_POST['id'])[0];
				$name = explode(" ", $_POST['name']);
				for($index = 1; $index < count($name); $index++){
					if(!empty($name[$index]))
						$last .= $name[$index] . " ";
				}
				$adminFunctions->updateUser($_POST['id'], $name[0], $last, $user->getRole(), $user->getEmail(), $user->getPassword());
				$data = "User Updated";
				print_r($data);
				break;

			case 'email':
				$uid = isset($_POST['uid']) ? $_POST['uid'] : null;
				$type = isset($_POST['type']) ? $_POST['type'] : null;
				$message = isset($_POST['message']) ? $_POST['message'] : null;
				$data = $adminFunctions->emailUser($uid,$type,$message);
				break;
			case 'emailAdmin':
				$message = isset($_POST['message']) ? $_POST['message'] : null;
				$data = $adminFunctions->emailAdmin($uid,$type,$message);
				break;
		}
	}

?>