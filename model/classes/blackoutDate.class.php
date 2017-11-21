<?php
/**
 * @auth Anthony Perez
 * @date 09/24/17
 **/

class blackoutDate{

	private $congregation_ID,$blackout_date_from,$blackout_date_to;

	// Get the congregation that is assoicated with the blackout dates
	public function getCongregationID(){return $this->congregation_ID;
	// Get the from date
	public function getFromDate(){return $this->blackout_date_from;}
	// Get the to date
	public function getToDate(){return $this->blackout_date_to;}
}
