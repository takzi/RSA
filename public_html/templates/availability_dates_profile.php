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
					<input id="dateArrowButton" type="button" value=">" onclick="insertDateValue()">
					<div id="dateValues" class="heighttext">
						<!-- INSERT CURRENT BLACKOUT DATES HERE FROM THE DB -->
						<?php 
							echo $adminFunctions->insertAvailablityIntoEditDriver($busID);
						?>
					</div>
				</div>
			
				<input class="editright" type="submit" value="Save" onclick="submitAvailabilityDates()">
			</form>		
		</div>
		</div>
</div> 

<?php
	echo $generalTemplate->insertFooter();
?>
<script>
	var availabilityDates = [];
	function insertDateValue(){
		var date = $("#date-input").val();
		var time_of_day =$("#time_of_day").val();
		if(date && time_of_day != -1){
			if($("#dateValues").text().trim() == "No availability dates"){
				$("#dateValues").text("");
			}

			availabilityDates.push(date + ","+ time_of_day);
			var formattedDate = getDateString(date) + ' - ' + getTimeOfDay(time_of_day);
			var p = document.createElement("p");
			p.setAttribute("class", "date-inputted");
			p.setAttribute("value", formattedDate);
			var txt = document.createTextNode(formattedDate);
			p.appendChild(txt);
			$("#dateValues").append(p);
			$("#date-input").val("");
		}
	}

	function getDateString(dateStr) {
	    [year, month, day] = dateStr.split("-");

	    return month + '/' + day + '/' + year;
	}

	function submitAvailabilityDates(){
		console.log(availabilityDates);
		for(var i = 0 ; i < availabilityDates.length; i++ ){
			[date, time_of_day] = availabilityDates[i].split(",");
			$.ajax({
			  type: "POST",
			  url: "admin/submitForm.php",
			  data:{action:'submitAvailabilityDates', busID: <?php echo $busID ?>, availabilityDate: date, timeOfDay: time_of_day},
			  success: function(){
			    alert("The availability dates are now saved");
			  },
			  error: function(){
			    alert("There is an error with the submit");
			    exit();
			  }
			});
		}
	}

	function getTimeOfDay(timeOfDayValue){
		var timeOfDay = ['Any', 'Morning', 'Afternoon'];
		return timeOfDay[timeOfDayValue - 1];
	}

</script>