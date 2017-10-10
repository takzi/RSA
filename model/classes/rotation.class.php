<?php
/**
 * @auth Anthony Perez
 * @date 09/11/17
 **/

class Rotation{

	private $id, $rotation_number, $congregation_ID, $rotation_date_from, $rotation_date_to;

	public function getID(){return $this->id;}
	public function getRotationNumber(){return $this->rotation_number;}
	public function getCongregationID(){return $this->congregation_ID;}
	public function getRotationDateFrom(){return $this->rotation_date_from;}
	public function getRotationDateTo(){return $this->rotation_date_to;}
}
