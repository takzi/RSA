<?php
	/**
	 * View/Request Bus Driver's Availability page for RSA
	 * 
	 * @author     Tiandre Turner	 
	 * @author     Kristen Merritt
	 * @version    Release: 1.0
	 * @date       11/28/17
	 */
	 
	$page='RAIHN View/Request Availability Dates';
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
	// Gets Bus Driver ID
	$busDriverUser = $adminFunctions->getBusDriveryByContactID($_SESSION['id'])[0];
	$busID = $busDriverUser->getID();
	
?>
<script src="../js/default.js"></script>
<div id="adminLink">
		<a href="profile.php">Profile</a> > <a href="#">View/Request Availability Dates</a>
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
				<br><br>Availability Dates<br><br>
				<div id="date-container" class="clearfix">
					<input id="date-input" class="text" type="date" name="from-date-input" value="">
					<select id='time_of_day' name='time_of_day'>
						<option value='-1'>Select a time of day</option>
						<option value='1'>Any</option>
						<option value='2'>Morning</option>
						<option value='3'>Afternoon</option>
					</select>
					<input id="dateArrowButton" class="availability" type="button" value=">" >
					<textarea id="dateValues" class="heighttext">
						<?php 
							echo $adminFunctions->insertAvailablityIntoEditDriver($busID);
						?>
					</textarea>
				</div>
				<input type="hidden" id="busDriverUID" name="busDriverUID" value="<?php echo $busID; ?>" />
				<input class="editright" id="updateAvailability" type="submit" value="Save">
			</form>		
		</div>
		</div>
</div> 

<?php
	echo $generalTemplate->insertFooter();
?>