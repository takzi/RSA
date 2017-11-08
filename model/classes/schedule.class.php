<?php
/**
 * @auth Anthony Perez
 * @date 09/24/17
 **/

class Schedule{

	private $date, $time_of_day, $bus_driver_ID;

	public function getScheduleDate(){return $this->date;}
	public function getScheduleTime(){return $this->time_of_day;}
	public function getBusDriverID(){return $this->bus_driver_ID;}
}
