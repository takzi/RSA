<?php
	/**
	 * Admin Edit Congregation page for RSA
	 * 
	 * @author     Tiandre Turner	 
	 * @author     Kristen Merritt
	 * @version    Release: 1.0
	 * @date       11/16/17
	 */
	 
	$page='RAIHN Admin Edit Congregation';
	$path_to_root="./../../";

	// starting a session
	session_start();
	
	// Setting up template system and loads functions for Admin
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');
	
	$generalTemplate = new GeneralTemplate($page, $path_to_root);
	$adminFunctions = new AdminFunctions($page, $path_to_root);

	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/admin.css" rel="stylesheet">';
	
	// Gets User ID
	$userID = $_GET['user'];
	$user = $adminFunctions->getUser($userID)[0];
?>
	<div id="adminLink">
		<a href="profile.php">Admin Home</a> > <a href="admin_user.php">Users</a> > <a href="#"><?php echo $user->getWholeName(); ?></a>
	</div>
	<h1><?php echo $user->getWholeName(); ?></h1>
	<div id="admin_container">
		<form id="edit-cong-form" align="middle">
			<input id="edit-leader-name" class="fulltext" type="text" name="user" value="<?php echo $user->getWholeName(); ?>">		
			<input class="editright" type="submit" value="Save">
		</form>		
	</div>
<?php
	echo $generalTemplate->insertFooter();
?>