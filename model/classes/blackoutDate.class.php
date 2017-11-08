<?php
/**
 * @auth Anthony Perez
 * @date 09/24/17
 **/

class blackoutDate{

	private $congregation_ID,$blackout_date_from,$blackout_date_to;

	public function getCongregationID(){return $this->congregation_ID;}
	public function getFromDate(){return $this->blackout_date_from;
	public function getToDate(){return $this->blackout_date_to;}
}
