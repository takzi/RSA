<?php
	$page='RAHIN Home';
	$path_to_root="./../";
	require_once($path_to_root."../BUS/GeneralTemplate.class.php");
      $generalTemplate = new GeneralTemplate($page, $path_to_root);

      echo $generalTemplate->insertHeader();

      require_once($path_to_root."../BUS/schedule/BusDriverSchedule.class.php");
      $busDriverScheduler = new BusDriverSchedule($path_to_root, $page);
?>
<link rel="stylesheet" type="text/css" href="<?php echo $path_to_root ?>css/schedule.css">
<div id="schedule">
	<header>
		<h1>January 2018 - Bus Driver Schedule</h1>
	</header>
      <?php echo $busDriverScheduler->insertInProgressBusDriverSchedules(); ?>
</div>
<?php
	echo $generalTemplate->insertFooter();
?>