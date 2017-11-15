<?php
/**
 * Holds all of the functionality relating to
 * the congregation schedule for the RSA site.
 *
 *
 * @author     Kristen Merritt
 * @author     Tiandre Turner
 * @version    Release: 1.0
 * @date       11/15/2017
 */

class CongregationSchedule {
	private $path_to_root; // provide the location of the root of public_html
	private $page;         // the page title
	private $db;           // the database object

	/**
	 * Constructors for the CongregationSchedule
	 * that initializes the path, page, and db.
	 * 
	 * @param string $path_to_root path to public_html root
	 * @param string $page         page name
	 */
	public function __construct($path_to_root, $page){
		$this->path_to_root = $path_to_root;
		$this->page = $page;

		require_once($this->path_to_root.'../model/DB.class.php');
		$this->db = new DB($this->path_to_root);
	}

	/**
	 * Inserts the congregation schedule
	 * onto the page.
	 * 
	 * @return string html of schedule
	 */
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

		return "<table class='table'>
					<tr>
						<th>Congreation</th>
						<th>Start Day</th>
						<th>End Day</th>
					</tr>".$tr."
				</table>\n";
	}

	/**
	 * Inserts the congregation schedule
	 * of a specific congregation.
	 * 
	 * @param  int    $_id id of congregation
	 * @return string      html of schedule
	 */
	function insertCongregationScheduleById($_id){
		if(!empty($congregation = $this->db->getCongregationByContactID($_id))){
			$rotations = $this->getSingleCongregationRotationBackup($congregation[0]->getID());
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

			return $tr;
		}
		return "You're not associated with any congregation.";
	}

	/**
	 * Retreives all of the rotations
	 * of all congregations.
	 * 
	 * @return Rotation rotation object
	 */
	function getAllCongregationRotations(){
		return $this->db->getAllRotations();
	}

	
	// function getSingleCongregationRotation($_id){
	// 	return $this->db->getRotation($_id);
	// }

	/**
	 * Retreives all of the rotations of
	 * a specific cong.
	 * 
	 * @param  int      $_id id of cong
	 * @return Rotation      rotation object
	 */
	function getSingleCongregationRotationBackup($_id){
		return $this->db->getRotationByCongregationId($_id);
	}

	/**
	 * Adds a new rotation into the DB.
	 * 
	 * @param int    $_rotationID       rotation id
	 * @param int    $_rotationNumber   rotation num
	 * @param int    $_congregationID   cong id
	 * @param string $_rotationDateFrom date
	 * @param string $_rotationDateTo   date
	 */
	function addNewRotation($_rotationID,$_rotationNumber,
		$_congregationID,$_rotationDateFrom,$_rotationDateTo){
		$this->db->insertNewRotation($_rotationID,$_rotationNumber,
		$_congregationID,$_rotationDateFrom,$_rotationDateTo);
	}

	/**
	 * Updates a rotation.
	 * 
	 * @param int    $_rotationID       rotation id
	 * @param int    $_rotationNumber   rotation num
	 * @param int    $_congregationID   cong id
	 * @param string $_rotationDateFrom date
	 * @param string $_rotationDateTo   date
	 */
	function updateRotation($_rotationID,$_rotationNumber,
		$_congregationID,$_rotationDateFrom,$_rotationDateTo){
		$this->db->updateRotation($_rotationID,$_rotationNumber,
		$_congregationID,$_rotationDateFrom,$_rotationDateTo);
	}

	/**
	 * Deletes a rotation.
	 * 
	 * @param  int $_rotationID     rotation id
	 * @param  int $_rotationNumber rotation num
	 * @param  int $_congregationID cong id
	 */
	function deleteRotation($_rotationID,$_rotationNumber,$_congregationID){
		$this->db->deleteRotation($_rotationID,$_rotationNumber,$_congregationID);
	}

	/**
	 * Retreives a cong name.
	 * 
	 * @param  int    $_id cong id
	 * @return string      cong name
	 */
	function getCongregationName($_id){
		return $this->db->getCongregationName($_id);
	}

	/**
	 * Retreives a congregation name by
	 * the contact associated with it.
	 * 
	 * @param  int    $_id contact id
	 * @return string      cong name
	 */
	function getCongregationNameByContactID($_id){
		return $this->db->getCongregationNameByContactID($_id)["name"];
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