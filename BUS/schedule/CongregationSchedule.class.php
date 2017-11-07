<?php

class CongregationSchedule {
	private $path_to_root;
	private $page;
	private $db;

	public function __construct($path_to_root, $page){
		$this->path_to_root = $path_to_root;
		$this->page = $page;

		require_once($this->path_to_root.'../model/DB.class.php');
		$this->db = new DB($this->path_to_root);
	}

	function insertCongregationSchedule(){
		$rotations = $this->getAllCongregationRotations();
		$tr = "";

		foreach($rotations as $rotation){
			$congregationName = $this->getCongregationName($rotation->getCongregationID());
			$startDate = $rotation->getRotationDateFrom();
			$endDate = $rotation->getRotationDateTo();
			$tr .= "<tr>\n
						<td>".$congregationName["name"]."</td>\n
						<td>".$startDate."</td>\n
						<td>".$endDate."</td>\n
					</tr>\n";
		}

		return "<table>
					<tr>
						<th>Congreation</th>
						<th>Start Day</th>
						<th>End Day</th>
					</tr>".$tr."
				</table>\n";
	}

	function insertCongregatonSchedule($_id){
		$congregationName = $this->getCongregationName($rotation->getCongregationID());
		$rotations = $this->getSingleCongregationRotation($_id);
		$tr = "";
		foreach($rotations as $rotation){
			$startDate = $rotation->getRotationDateFrom();
			$endDate = $rotation->getRotationDateTo();
			if($this->formatDate($startDate, "Y") != $this->formatDate($endDate, "Y")){
				$tr .= $this->formatDate($startDate, "F d, Y - ") . $this->formatDate($endDate, "F d, Y");
			}
			else{
				$tr .= $this->formatDate($startDate, "F d - ") . $this->formatDate($endDate, "d, Y");
			}
			$tr .= "<br><br>";
		}
	}

	function getAllCongregationRotations(){
		return $this->db->getAllRotations();
	}

	function getSingleCongregationRotation($_id){
		return $this->db->getRotation($_id);
	}

	function addNewRotation($_rotationID,$_rotationNumber,
		$_congregationID,$_rotationDateFrom,$_rotationDateTo){
		$this->db->insertNewRotation($_rotationID,$_rotationNumber,
		$_congregationID,$_rotationDateFrom,$_rotationDateTo);
	}

	function updateRotation($_rotationID,$_rotationNumber,
		$_congregationID,$_rotationDateFrom,$_rotationDateTo){
		$this->db->updateRotation($_rotationID,$_rotationNumber,
		$_congregationID,$_rotationDateFrom,$_rotationDateTo);
	}

	function deleteRotation($_rotationID,$_rotationNumber,$_congregationID){
		$this->db->deleteRotation($_rotationID,$_rotationNumber,$_congregationID);
	}

	function getCongregationName($_id){
		return $this->db->getCongregationName($_id);
	}

	function formatDate($date,$format){
		//return $date
	}

}

?>