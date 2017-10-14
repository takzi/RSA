<?php

function checkUniqueEmail($_db, $_email){
	$users = $_db->getUserByEmail($_email);

	if(count($users) > 0){
		return false;
	}

	return true;
}

function createNewAccount($_db, $_fname, $_lname, $_role, $_email, $_pass){
	$_db->insertNewUser($_fname, $_lname, $_role, $_email, $_pass);

	// create new bus driver or congregation 
}

?>