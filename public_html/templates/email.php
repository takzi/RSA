<?php
	/**
	 * Congregation Schedule Page for RSA
	 *  
	 * @author     Kristen Merritt
	 * @version    Release: 1.0
	 * @date       12/1/17
	 */
	 

	$page='Email';
	$path_to_root="./../";

	// Setting up template system
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	$generalTemplate = new GeneralTemplate($page, $path_to_root);

	// Starting the session
	session_start();

	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/email.css" rel="stylesheet">';
?>

	<div id="email_container" class="clearfix">
		<h1 id ="email_h1">Send Message</h1>
		<br>
		<form id="email-form">
			<textarea id="email-content" name="email-content" rows="10" cols="50"> </textarea>
			<input type="submit" value="Send" />
		</form>
	</div>

<?php
	echo $generalTemplate->insertFooter();
?>