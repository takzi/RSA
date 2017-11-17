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
	$page='RAHIN Admin Edit Congregation';
	$path_to_root="./../../";

	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');

	$generalTemplate = new GeneralTemplate($page, $path_to_root);
	$adminFunctions = new AdminFunctions($page, $path_to_root);

	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/admin.css" rel="stylesheet">';

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
			<input id="edit-name" class="fulltext" type="text" name="congregation" value="<?php echo $cong->getName(); ?>">
			<input id="edit-leader-name" class="fulltext" type="text" name="congregation_leader" value="<?php echo $user->getWholeName(); ?>">
			<br><br>Blackout Dates<br><br>
			<div id="date-container" class="clearfix">
				<input id="date-input" class="text" type="date" name="date-input" value="">
				<input id="dateArrowButton" type="button" value=">" onclick="insertDateValue()">
				<div id="dateValues" class="heighttext">
					<!-- INSERT CURRENT BLACKOUT DATES HERE FROM THE DB -->
					<?php 
						echo $adminFunctions->insertBlackoutDatesIntoEditCongregation($congID);
					?>
				</div>
			</div>
		
			<input class="editright" type="submit" value="Save">
		</form>		
	</div>
<?php
	echo $generalTemplate->insertFooter();
?>