<?php
/**
 * @auth Anthony Perez
 * @date 09/24/17
 **/

class Schedule{

	private $date, $time_of_day, $bus_driver_ID;

	// Get the schedule date
	public function getScheduleDate(){return $this->date;}
	// Get the schedule time
	public function getScheduleTime(){return $this->time_of_day;}
	// Get the bus driver that is associated with this schedule.
	public function getBusDriverID(){return $this->bus_driver_ID;}
}
