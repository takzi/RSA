<?php
/**
 * Holds all of the functionality relating to
 * the bus driver schedule for the RSA site.
 *
 *
 * @author     Kristen Merritt
 * @author     Tiandre Turner
 * @version    Release: 1.0
 * @date       11/15/2017
 */

class BusDriverSchedule {
	private $path_to_root; // provide the location of the root of public_html
	private $page;         // the page title
	private $db;           // the database object

	/**
	 * Constructor for the BusDriverSchedule 
	 * that initializes root, page, and db.
	 * 
	 * @param string $path_to_root path of public_html root
	 * @param string $page         page name
	 */
	public function __construct($path_to_root, $page){
		$this->path_to_root = $path_to_root;
		$this->page = $page;

		require_once($this->path_to_root.'../model/DB.class.php');
		$this->db = new DB($this->path_to_root);
	}

	/**
	 * Inserts the in progress bus driver
	 * schedule dates.
	 * 
	 * @return string html of schedule
	 */
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

		return "<table class='table'>
					<tr>
						<th colspan='3' class='header'>Bus Driver Schedule</th>
					</tr>
					<tr>
						<th>Bus Driver</th>
						<th>Date</th>
						<th>Time Of Day</th>
					</tr>
					".$tr."
				</table>\n";
	}

	/**
	 * Inserts all of the in progress schedule
	 * of a specific bus driver.
	 * 
	 * @param  int $_id    ID of the bus driver
	 * @return string      html of the schedule
	 */
	function insertInProgressBusDriverSchedulesById($_id){
		if(!empty($currentBusDriver = $this->db->getBusDriverByContactID($_id))){
			$schedules = $this->getDriverInProgressScheduleBackup($currentBusDriver[0]->getID());
			$tr = "";

			foreach($schedules as $schedule){
				$date = $schedule->getScheduleDate();
				$timeOfDay = $schedule->getScheduleTime();
				$tr .= "<tr>\n
							<td>".$this->formatDate($date, "M d")."</td>\n
							<td>".$timeOfDay."</td>\n
						</tr>\n";
			}

			return $tr;
		}
		return "No information found associated with your account";
	}

	/**
	 * Retreives all of the in progress
	 * schedules for bus drivers.
	 * 
	 * @return Schedule scheduke object
	 */
	function getAllInProgressSchedules(){
		return $this->db->getSchedulesByStatus("In Progress");
	}

	// // unsure what to do with this
	// function getDriverInProgressSchedule($_id){	
	// 	return $this->db->getRotation($_id);
	// }

	/**
	 * Retreives the bus driver in progress
	 * schedule.
	 * 
	 * @param  int $_id      id of driver
	 * @return Schedule      schedule object
	 */
	function getDriverInProgressScheduleBackup($_id){
		return $this->db->getSchedulesByDriver($_id);
	}

	/**
	 * Adds a new schedule for a bus driver.
	 * @param string $_date        date
	 * @param string $_timeOfDay   time
	 * @param int    $_busDriverID bus driver id
	 * @param string $_status      status
	 */
	function addNewSchedule($_date,$_timeOfDay,$_busDriverID,$_status){
		$this->db->insertNewSchedule($_date,$_timeOfDay,$_busDriverID,$_status);
	}

	/**
	 * Updates a bus driver schedule.
	 * @param  int    $_id          id of schedule
	 * @param  string $_date        date
	 * @param  string $_timeOfDay   time
	 * @param  int    $_busDriverID id of driver
	 * @param  string $_status      status
	 */
	function updateSchedule($_id,$_date,$_timeOfDay,$_busDriverID,$_status){
		$this->db->updateSchedule($_id,$_date,$_timeOfDay,$_busDriverID,$_status);
	}

	/**
	 * Deletes a schedule.
	 * 
	 * @param  int $_id id of schedule
	 */
	function deleteSchedule($_id){
		$this->db->deleteSchedule($_id);
	}

	/**
	 * Retreives a bus driver name.
	 * 
	 * @param  int    $_id id of driver
	 * @return string      driver name
	 */
	function getBusDriverName($_id){
		return $this->db->getBusDriverName($_id);
	}

	/**
	 * Formats the date
	 * @param  string $_date   date
	 * @param  string $_format format of date
	 * @return string          formatted date
	 */
	function formatDate($_date,$_format){
		return date($_format, strtotime($_date));
	}
}

?>