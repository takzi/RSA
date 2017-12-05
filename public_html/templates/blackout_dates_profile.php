<?php
	/**
	 * View/Request Congregation's blackout dates page for RSA
	 * 
	 * @author     Tiandre Turner	 
	 * @author     Kristen Merritt
	 * @version    Release: 1.0
	 * @date       11/28/17
	 */
	 
	$page='RAIHN View/Request Blackout Dates';
	$path_to_root="./../";
	session_start();
	
	// Setting up template system and loads functions for Admin
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');
	
	$generalTemplate = new GeneralTemplate($page, $path_to_root);
	$adminFunctions = new AdminFunctions($page, $path_to_root);

	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/admin.css" rel="stylesheet">';
	echo '<link href="'.$path_to_root.'css/profile.css" rel="stylesheet">';
	// Gets Congregation ID
	$cong = $adminFunctions->getCongregationByContactID($_SESSION['id'])[0];
	$congID = $cong->getID();
	
?>
<script src="../js/default.js"></script>
<div id="adminLink">
		<a href="profile.php">Profile</a> > <a href="#">View/Request Blackout Dates</a>
	</div>
<h1 id ="profile_h1"><?php echo $_SESSION['fullname']; ?></h1>
	<div id="profile_container">
		<div align="left">
			<a href="change_password.php"><button>Change Password</button></a>	
			<br>
			<a href="profile.php"><button>View Schedule</button></a>
			<br>
			<button>Request Schedule Change</button>
		</div>

		<div align="right"> 
		<div id="admin_container">
			<form id="edit-cong-form" align="middle">
				<br><br>Blackout Dates<br><br>
				<div id="date-container" class="clearfix">
					From <input id="date-from-input" class="text" type="date" name="from-date-input" value="">
					To <input id="date-to-input" class="text" type="date" name="to-date-input" value="">
					<input id="dateArrowButton" class="blackout" type="button" value=">" >
				<textarea id="dateValues" name="dateValues" class="heighttext">
					<?php 
						echo $adminFunctions->insertBlackoutDatesIntoEditCongregation($congID);
					?>						
				</textarea> 
				</div>
				<input type="hidden" id="congUID" name="congUID" value="<?php echo $congID; ?>" />
				<input class="editright" id="updateBlackoutDates" type="submit" value="Save">
			</form>		
		</div>
		</div>
</div> 

<?php
	echo $generalTemplate->insertFooter();
?>
