<?php

function getUserByEmail($db, $_email){
	$users = $db->getUserByEmail($_email);

	if(count($users) == 0){
		return null;
	} 

	$user = $users[0];
	$id = $user->getId();
	$firstName = $user->getFirstName();
	$lastName = $user->getLastName();
	$email = $user->getEmail();
	$password = $user->getPassword();
	$role = $user->getRole();	
	return [$id, $firstName, $lastName, $email, $password, $role];
}

?>