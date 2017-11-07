<?php
	$page='RAHIN Admin Congregation';
	$path_to_root="./../";
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	$generalTemplate = new GeneralTemplate($page, $path_to_root);

	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/admin.css" rel="stylesheet">';
?>
	<div id="adminLink">
		<a href="#">Admin Home</a> > <a href="#">Congregation</a> > <a href="#">Congregation 1</a>
	</div>
	<h1>Congregation 1</h1>
	<div id="admin_container">
		<div align="middle">
		<input type="text" id="fulltext" name="congregation" value="Congregation Name">
		<br>
		<br>
		Blackout Dates
		<br>
		<br>
		<input type="text" id="text" name="date" value="8/8/17">
		<input type="button" value=">">
		<input type="text" id="heighttext" name="date" value="">
		<br>
		<br>
		<input type="text" id="fulltext" name="infomation1" value="Infomation">
		<br>
		<br>
		<input type="text" id="fulltext" name="infomation2" value="Infomation">
		<br>
		<br>
		<input type="button" id="editright" value="Save">
		</div>
<?php
	echo $generalTemplate->insertFooter();
?>