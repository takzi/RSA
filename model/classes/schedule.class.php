<?php
/**
 * @auth Anthony Perez
 * @date 09/24/17
 **/

class Schedule{

	private $date, $time_of_day, $driver_status, $bus_driver_ID, $status;

	// Get the schedule date
	public function getScheduleDate(){return $this->date;}
	// Get the schedule time
	public function getScheduleTime(){return $this->time_of_day;}
	// Get the status of bus driver that is associated with this schedule.
	public function getBusDriverStatus(){return $this->driver_status;}
	// Get the bus driver that is associated with this schedule.
	public function getBusDriverID(){return $this->bus_driver_ID;}
	// Get the status of this scheduled date.
	public function getScheduleStatus(){return $this->status;}
}