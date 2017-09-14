<?php

/**
 * Returns a sanitized string
 * @param {string} string 
 * @return {string}
 */
function sanitizeString($string){
	$string = trim($string);
	return filter_var($string, FILTER_SANITIZE_STRING);
}

/**
 * Returns a sanitized email
 * @param {string} email 
 * @return {string}
 */
function sanitizeEmail($email){
	$email = trim($email);
	return filter_var($email, FILTER_SANITIZE_EMAIL); 
}

/**
 * Returns boolean based on whether or not the email is valid
 * @param {string} email 
 * @return {bool}
 */
function validateEmail($email){
	$email = trim($email);
	return filter_var($email, FILTER_VALIDATE_EMAIL); 
}

/**
 * Returns a sanitized number
 * @param {int} number 
 * @return {int}
 */
function sanitizeInt($number){
	$number = trim($number);
	return filter_var($number, FILTER_SANITIZE_NUMBER_INT);
}

/**
 * Returns boolean based on whether or not the number is valid
 * @param {int} number 
 * @return {bool}
 */
function validateInt($number){
	return filter_var($number, FILTER_VALIDATE_INT);
}

/**
 * Returns a sanitized URL
 * @param {string} url 
 * @return {string}
 */
function sanitizeURL($url){
	$url = trim($url);
	return filter_var($url, FILTER_SANITIZE_URL);
}

/**
 * Returns boolean based on whether or not the URL is valid
 * @param {string} url 
 * @return {bool}
 */
function validateInt($url){
	return filter_var($url, FILTER_VALIDATE_URL);
}


?>