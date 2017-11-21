<?php
	/**
	 * Bus Schedule Page for RSA
	 * 
	 * @author     Chevy Mac	 
	 * @author     Kristen Merritt
	 * @author     Tiandre Turner	 
	 * @version    Release: 1.0
	 * @date       11/17/17
	 */
	 
	$page='Bus Driver Schedule';
	$path_to_root="./../";
	
	// Starting the session
	session_start();
	
	// Setting up template system
	require_once($path_to_root."../BUS/GeneralTemplate.class.php");
	$generalTemplate = new GeneralTemplate($page, $path_to_root);
	
	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/schedule.css" rel="stylesheet">';
	
	// Setting up functions for Bus Driver Schedule and inserts the schedule to the page
	require_once($path_to_root."../BUS/schedule/BusDriverSchedule.class.php");
	$busDriverScheduler = new BusDriverSchedule($path_to_root, $page);
?>

	<div class="schedule-container">
		<?php echo $busDriverScheduler->insertInProgressBusDriverSchedules(); ?>
	</div>
	
<?php
	echo $generalTemplate->insertFooter();
?>