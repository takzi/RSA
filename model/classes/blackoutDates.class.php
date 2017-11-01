<?php
/**
 * @auth Anthony Perez
 * @date 09/24/17
 **/

class blackoutDates{

	private $congregation_ID, $blackout_date_to, $blackout_date_from;

	public function getID(){return $this->congregation_ID;}
	public function getBlackoutDateTo(){return $this->blackout_date_to;}
	public function getBlackoutDateFrom(){return $this->blackout_date_from;}
}
