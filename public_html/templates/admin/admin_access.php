<?php
	//include('../../../BUS/admin/AdminFunctions.class.php');
	$page='RAIHN Admin Access';
	$path_to_root="./../../";
 	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');
 	// require_once($path_to_root. '../BUS/schedule/generate_congregations_schedule.php');
 	// require_once($path_to_root. '../BUS/schedule/generate_bus_driver_schedule.php');
 	
if(isset($_POST['action'])){
		$adminFunctions = new AdminFunctions($page, $path_to_root);
	
		
		$action = $_POST['action'];

		switch ($action) {
			case 'generateCongregationSchedule':
				$generalCongSchedule = $adminFunctions->generateCongregationSchedule();
				print_r("generating schedule for congregation");
				break;

			case 'generateBusDriverSchedule':
				$generalBusSchedule = $adminFunctions->generateBusDriverSchedule(); 
				print_r("generating schedule for  bus drivers");
				break;

			case 'updateCongregation':
				//$adminFunctions->updateCongregation($_id, $_contactID, $_POST['cong'], $_POST['leaderName'], $_POST['blackouts']);
				$data = "Updating Congregation";
				print_r($data);
				break;
			
			case 'updateBusDriver':
				$data = "Updating Driver";
				print_r($data);
				break;

			case 'reset':
			// only need to call speific
				//$this->resetPassword($_POST['type'], $_POST['userId']);
				$data = "Password Reset";
				print_r($data);
				break;

			case 'delete':
				//$data = $this->delete($_POST['type'], $_POST['id'], $_POST['name']);
				$data = "Delete this fool";
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