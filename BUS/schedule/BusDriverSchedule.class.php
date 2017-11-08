<?php

class BusDriverSchedule {
	private $path_to_root;
	private $page;
	private $db;

	public function __construct($path_to_root, $page){
		$this->path_to_root = $path_to_root;
		$this->page = $page;

		require_once($this->path_to_root.'../model/DB.class.php');
		$this->db = new DB($this->path_to_root);
	}

	function insertInProgressBusDriverSchedules(){
		$schedules = $this->getAllInProgressSchedules();
		$tr = "";

		foreach($schedules as $schedule){
			$busDriverName = $this->getBusDriverName($schedule->getBusDriverID());
			$date = $schedule->getScheduleDate();
			$timeOfDay = $schedule->getScheduleTime();
			$tr .= "<tr>\n
						<td>".$busDriverName["name"]."</td>\n
						<td>".$date."</td>\n
						<td>".$timeOfDay."</td>\n
					</tr>\n";
		}

		return "<table>
					<tr>
						<th>Bus Driver</th>
						<th>Date</th>
						<th>Time Of Day</th>
					</tr>".$tr."
				</table>\n";
	}

	function insertInProgressBusDriverSchedulesById($_id){
		$currentBusDriver = $this->db->getBusDriverByContactID($_id)[0];
		$schedules = $this->getDriverInProgressScheduleBackup($currentBusDriver->getID());
		$tr = "";

		foreach($schedules as $schedule){
			$date = $schedule->getScheduleDate();
			$timeOfDay = $schedule->getScheduleTime();
			//$congregation = $schedule->get // need to know how to get the specific congregation for the bus driver.
			$tr .= "<tr>\n
						<td>".$date."</td>\n
						<td>".$timeOfDay."</td>\n
					</tr>\n";
		}

		return $tr;
	}

	function getAllInProgressSchedules(){
		return $this->db->getSchedulesByStatus("In Progress");
	}

	// unsure what to do with this
	function getDriverInProgressSchedule($_id){
		return $this->db->getRotation($_id);
	}

	// unsure what to do with this, I wrote this. added backup to avoid the cannot redeclare error.
	function getDriverInProgressScheduleBackup($_id){
		return $this->db->getSchedulesByDriver($_id);
	}

	function addNewSchedule($_date,$_timeOfDay,$_busDriverID,$_status){
		$this->db->insertNewSchedule($_date,$_timeOfDay,$_busDriverID,$_status);
	}

	function updateSchedule($_id,$_date,$_timeOfDay,$_busDriverID,$_status){
		$this->db->updateSchedule($_id,$_date,$_timeOfDay,$_busDriverID,$_status);
	}

	function deleteSchedule($_id){
		$this->db->deleteSchedule($_id);
	}

	function getBusDriverName($_id){
		return $this->db->getBusDriverName($_id);
	}

}

?>