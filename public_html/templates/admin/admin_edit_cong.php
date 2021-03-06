<script src="../../js/default.js">
	// function insertDateValue(){
	// 	var date = $("#date-from-input").val() + " - " + $("#date-to-input").val();
	// 	var txt = document.createTextNode(date+"\n");
	// 	$("#dateValues").append(txt);
	// 	$("#date-from-input").val("");
	// 	$("#date-to-input").val("");
	// }
</script>

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
	
	// Gets Congregation ID
	$congID = $_GET['congregation'];
	$cong = $adminFunctions->getCongregation($congID)[0];
	$user = $adminFunctions->getUser($cong->getContactId())[0];
?>
	<div id="adminLink">
		<a href="profile.php">Admin Home</a> > <a href="admin_cong.php">Congregation</a> > <a href="#"><?php echo $cong->getName(); ?></a>
	</div>
	<h1><?php echo $cong->getName(); ?></h1>
	<div id="admin_container">
		<form id="edit-cong-form" align="middle">
			Congregation Name: <input id="edit-name" class="fulltext" type="text" name="congregation" value="<?php echo $cong->getName(); ?>">
			<br><br>
			Congregation Leader Name: <input id="edit-leader-name" class="fulltext" type="text" name="congregation_leader" value="<?php echo $user->getWholeName(); ?>">
			<br><br>Blackout Dates<br><br>
			<div id="date-container" class="clearfix">
				<input id="date-from-input" class="text" type="date" name="date-from-input" value="">
				<input id="date-to-input" class="text" type="date" name="date-to-input" value="">
				<br><br>
				<input id="dateArrowButton" class="blackout" type="button" value=">" >
				<textarea id="dateValues" name="dateValues" class="heighttext">
					<?php 
						echo $adminFunctions->insertBlackoutDatesIntoEditCongregation($congID);
					?>						
				</textarea> 
			</div>
			<input type="hidden" id="leaderUID" name="leaderUID" value="<?php echo $user->getID(); ?>"/>
			<input type="hidden" id="congUID" name="congUID" value="<?php echo $cong->getID(); ?>" />
			<input class="editright" id="updateCongregation" type="submit" value="Save">
		</form>		
	</div>
<?php
	echo $generalTemplate->insertFooter();
?>