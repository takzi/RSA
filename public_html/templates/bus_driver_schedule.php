<?php
	$page='Bus Driver Schedule';
	$path_to_root="./../";
	
	require_once($path_to_root."../BUS/GeneralTemplate.class.php");
	$generalTemplate = new GeneralTemplate($page, $path_to_root);

<<<<<<< HEAD
      // Starting the session
	  session_start();

      echo $generalTemplate->insertHeader();

      require_once($path_to_root."../BUS/schedule/BusDriverSchedule.class.php");
      $busDriverScheduler = new BusDriverSchedule($path_to_root, $page);
=======
	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/schedule.css" rel="stylesheet">';
	
	require_once($path_to_root."../BUS/schedule/BusDriverSchedule.class.php");
	$busDriverScheduler = new BusDriverSchedule($path_to_root, $page);
>>>>>>> fd9c546b5514c554a03406b08985e28226404d2e
?>
	<div class="schedule-container">
		<?php echo $busDriverScheduler->insertInProgressBusDriverSchedules(); ?>
	</div>
<?php
	echo $generalTemplate->insertFooter();
?>