<?php

	function getBusDriverSchedule(){

		$db = new DB();
		$schedule = $db->getSchedulesByStatus("In Progress");

		return json_encode($schedule[0]);
	}
?>