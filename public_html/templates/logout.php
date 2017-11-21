<?php
	/**
	 * Logout Page for RSA
	 * 
	 * @author     Kristen Merritt
	 * @version    Release: 1.0
	 * @date       11/16/17
	 */

	$page='Logout';
	$path_to_root="./../";

	// Starting the session
	session_start();
	
	// Setting up template system
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	$generalTemplate = new GeneralTemplate($page, $path_to_root);

	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();
	
	// Ending the session
	session_destroy();
?>
<div class="message">
	<h1> You have successfully logged out. </h1>
	<a href="<?php echo $path_to_root ?>index.php"> Return to home page. </a>
</div>

<?php
	echo $generalTemplate->insertFooter();
?>