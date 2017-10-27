<?php
/**
	 * Congregation Schedule Page for RSA
	 * 
	 * @author     Original Author: Kristen Merritt
	 * @version    Release: 1.0
	 * @date       10/26/17
	 */

	$page='Congregation Schedule';
	$path_to_root="./../";

	// Setting template system
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	$generalTemplate = new GeneralTemplate($page, $path_to_root);

	// Starting the session
	session_start();

	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();

	require_once($path_to_root.'../BUS/schedule/congregation_schedule.php');
	$congregationSchedule = new CongregationSchedule($path_to_root, $page);

	$rotations = $congregationSchedule->getAllCongregationRotations();

	foreach($rotations as $rotation){
		
	}

	echo $congregationSchedule->insertCongregationSchedule();

	echo $generalTemplate->insertFooter();
?>