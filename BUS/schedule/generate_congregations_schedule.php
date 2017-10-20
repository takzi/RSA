<?php 
require_once('../model/DB.class.php')
date_default_timezone_set('UTC');
define("threeMonths", 3);
define("sixDays", 6);
define("sevenDays", 7);

$db = new DB();


/*assignCongregations(calendar)
variable List for all congregations for three months
-        If all congregations are assigned, add to list and rearrange the order of congregations,
-        If length of list == 3, return with the calendar object.
-        Start with next week of the current month
o   If reach the last day of the month and the week is not full, then add the first few days of the next month.
-        for each congregation
o   if
 
once done add the ranking for each congregation.
 
validatingBlackoutDates(): method to loop through and check all the blackdates to ensure no conflicts.
 
Check the rotation number to ensure that the first and last congregation is not always swapping with each other.*/
 
/* 
-        get the current date (+7 days later) & the last day of the third month (modified to get the next sunday and the last saturday but checked)
-        if all congregation are assigned & 3 months are completed
-        if all congregation are assigned
o   then rearrange order
o   recall
-        once current congregation is assigned
o   break out of the loop to the next congregation
-        Check if current week is not owned by other congregations
-        Check if the requested holidays are not within the week even if the week is not a part of their blackout dates.*/
function generateSchedule(){
$congregations = $db->getAllCongregations();
$schedule = array();
$startDate = getDateTime('NOW');
$endDate = getDateTime('NOW');

// starting on a Sunday
$startDate = getModifiedDate($startDate, '+%d days', $sevenDays - getFormattedDate($startDate, 'N'));
// advancing in three months
$endDate = getModifiedDate($endDate, '+%d months', threeMonths));
// getting the last day of the third month
$endDate = getModifiedDate($endDate,'+%d days', (getFormattedDate($endDate, 't') - getFormattedDate($endDate, 'j')));

// if the end of the third month does not land on a Saturday.
if(($lengthOfEndDays = getFormattedDate($endDate, 'N')) != 6){
	$endDate = getModifiedDate($endDate,'+%d days', $sixDays - $lengthOfEndDays);
}

echo "The date from now and in three months is between " . $date->format('m-d-Y') . " & " . $newDate->format('m-d-Y') . "\n\n";


while($startDate <= $endDate){
    $tempEndDate = getModifiedDate($startDate,'+%d days', $sixDays - getFormattedDate($startDate, 'N'));
   // echo "<tr><td>" . getFormattedDate($startDate,'l m-d-Y') . " - " . getFormattedDate($tempEndDate,'l m-d-Y') .  "</td></tr>";
    $startDate = getModifiedDate($startDate,'+%d days', $sixDays - getFormattedDate($startDate, 'N'));
}



} // end function generateSchedule

function allCongregationsRAssigned($congregations, $rotations){
	//$rotations = $db->getAllRotations();
	foreach($congregations as $congregation){
		foreach($rotations as $rotation){
			if($rotation)
		}
	/*	$rotations = $db->getRotation($congregation->getID);
		$blackoutDates = $db->getBlackoutdatesForCongregations($congregation->getID);
		foreach($rotations as $rotation){
			if($rotation->getRotationDateFrom == $blackoutDates->getBlackoutDateFrom && )
		}*/
	}
}

function rearrageOrder($congregations){
	$tempCongregations = array();
	foreach($congregations as $congregation){
		if(validOrderConflict($congregation) && $congregation.current ==  $congregation.prev){
			$congregation.current = rand(count($congregations));
			$tempNewCongregations = array();
			continue;
		}
		array_push($tempCongregations, $congregation);
	}
	return $tempCongregations;
}

/*
-        Get the order based on the assigned weeks after all congregations are assigned
-        Create new variable to check for the previous rotation number.

 */
function validOrderConflict($currentCongregation, $congregations){
 foreach($congregations as $congregation){
 	if($congregation !== $currentCongregation && $congregation.current == $currentCongregation.current)
 		return true;
 }
 return false;
}

/** 
 * Get the DateTime object
 * 
 */
function getDateTime($when){
	return new DateTime($when);
}


function getModifiedDate($date, $formatQuery, $modifyDate){
	return $date->modify(sprintf($formatQuery, $modifyDate));
}

function getFormattedDate($date, $formatQuery){
	return $date->format($formatQuery);
}

?>