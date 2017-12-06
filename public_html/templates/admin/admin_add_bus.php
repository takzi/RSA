<?php
	/**
	 * Add new Cong Page for RSA
	 * 
	 * @author     Tiandre Turner
	 * @version    Release: 1.0
	 * @date       11/17/17
	 */
	 
	$page='Add Bus Driver';
	$path_to_root="./../../";
	
	// Setting up template system and loads functions for Admin
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');

	$generalTemplate = new GeneralTemplate($page, $path_to_root);
	$adminFunctions = new AdminFunctions($page, $path_to_root);

	// Starting the session
	session_start();
	
	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/admin.css" rel="stylesheet">';
?>
	<div id="adminLink">
		<a href="profile.php">Admin Home</a> > <a href="admin_add_bus.php">Add New Bus Driver</a>
	</div>
	<h1>Add A New Bus Driver</h1>
	<div id="admin_container">
		<form id="add-admin-form" align="middle">
			Select a Bus Driver User: <select id='cong-user' name='cong-user'>
				<option value='-1'>Select a Bus Driver</option>
			</select>
			<br/><br/>
			Phone Number: <input id="edit-number" class="fulltext" type="tel" name="phonenumber" value="">			
			<input class="editright" type="submit" value="Save">
		</form>		
	</div>
<?php
	echo $generalTemplate->insertFooter();
?>