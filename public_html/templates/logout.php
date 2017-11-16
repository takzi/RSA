<?php
	$page='Logout';
	$path_to_root="./../";

	session_start();
	
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	$generalTemplate = new GeneralTemplate($page, $path_to_root);

	echo $generalTemplate->insertHeader();

	session_destroy();
?>
<div class="message">
	<h1> You have successfully logged out. </h1>
	<a href="<?php echo $path_to_root ?>index.php"> Return to home page. </a>
</div>

<?php
	echo $generalTemplate->insertFooter();
?>