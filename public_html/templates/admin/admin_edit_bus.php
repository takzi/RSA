<script>
	function insertDateValue(){
		var date = $("#date-input").val();
		var p = document.createElement("p");
		p.setAttribute("class", "date-inputted");
		p.setAttribute("value", date);
		var txt = document.createTextNode(date);
		p.appendChild(txt);
		$("#dateValues").append(p);
		$("#date-input").val("");
	}
</script>

<?php
	/**
	 * Admin Edit Bus Driver page for RSA
	 * 
	 * @author     Tiandre Turner
	 * @author     Kristen Merritt
	 * @version    Release: 1.0
	 * @date       11/13/17
	 */
	 
	$page='RAHIN Admin Edit Bus Driver';
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
	
	// Gets Bus Driver ID
	$busID = $_GET['driver']; 
	$busDriverUser = $adminFunctions->getBusDriver($busID)[0];
?>
	<div id="adminLink">
		<a href="profile.php">Admin Home</a> > <a href="admin_bus.php">Bus Drivers</a> > <a href="#"><?php echo $busDriverUser->getWholeName(); ?></a>
	</div>
	<h1><?php echo $busDriverUser->getWholeName(); ?></h1>
	<div id="admin_container">
		<form id="edit-bus-form" align="middle">
			<input id="edit-name" class="fulltext" type="text" name="congregation" value="<?php echo $busDriverUser->getWholeName(); ?>">

			<br><br>Availability Dates<br><br>
			<div id="date-container" class="clearfix">
				<input id="date-input" class="text" type="date" name="date-input" value="">
				<input id="dateArrowButton" type="button" value=">" onclick="insertDateValue()">
				<div id="dateValues" class="heighttext">
					<!-- INSERT CURRENT BLACKOUT DATES HERE FROM THE DB -->
					<?php
						echo $adminFunctions->insertAvailablityIntoEditDriver($busID);
					?>
					<!-- <p class="date-inputted" value="date string">date string</p> -->
				</div>
			</div>
		
			<input class="editright" id="updateBusDriver" type="submit" value="Save">
		</form>		
	</div>
<?php
	echo $generalTemplate->insertFooter();
?>