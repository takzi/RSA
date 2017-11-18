<?php
/**
 * @auth Anthony Perez
 * @date 09/11/17
 **/

class Rotation{

	private $id, $rotation_number, $congregation_ID, $rotation_date_from, $rotation_date_to;

	// Get the rotation id
	public function getID(){return $this->id;}
	// Get the rotation number of whose turn
	public function getRotationNumber(){return $this->rotation_number;}
	// Get the id of the congregation that is associated with the rotation
	public function getCongregationID(){return $this->congregation_ID;}
	// Get the from rotation date
	public function getRotationDateFrom(){return $this->rotation_date_from;}
	// Get the to rotation date
	public function getRotationDateTo(){return $this->rotation_date_to;}
}
