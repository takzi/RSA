<?php
	/**
	 * Admin Edit Congregation page for RSA
	 * 
	 * @author     Tiandre Turner	 
	 * @author     Kristen Merritt
	 * @version    Release: 1.0
	 * @date       11/16/17
	 */
	 
	$page='RAHIN Admin Edit Congregation';
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

<div id="adminLink">
		<a href="profile.php">Admin Home</a> > <a href="admin_cong.php">Congregation</a> > <a href="#"><?php echo $cong->getName(); ?></a>
	</div>
<h1 id ="profile_h1"><?php echo $_SESSION['fullname']; ?></h1>
	<div id="profile_container">
		<div align="left">
			<button>Change Password</button> 	
			<br>
			<button>View Schedule</button>
			<br>
			<button>Request Schedule Change</button>
		</div>

		<div align="right"> 
		<div id="admin_container">
			<form id="edit-cong-form" align="middle">
				<br><br>Blackout Dates<br><br>
				<div id="date-container" class="clearfix">
					From <input id="from-date-input" class="text" type="date" name="from-date-input" value="">
					To <input id="to-date-input" class="text" type="date" name="to-date-input" value="">
					<input id="dateArrowButton" type="button" value=">" onclick="insertDateValue()">
					<div id="dateValues" class="heighttext">
						<!-- INSERT CURRENT BLACKOUT DATES HERE FROM THE DB -->
						<?php 
							echo $adminFunctions->insertBlackoutDatesIntoEditCongregation($congID);
						?>
					</div>
				</div>
			
				<input class="editright" type="button" value="Save" onclick="submitBlackoutDates()">
			</form>		
		</div>
		</div>
</div> 

<?php
	echo $generalTemplate->insertFooter();
?>
<script>
	var blackoutDates = [];
	function insertDateValue(){
		var fromDate = $("#from-date-input").val();
		var toDate = $("#to-date-input").val();
		if(fromDate && toDate){
			if($("#dateValues").text().trim() == "No blackout dates"){
				//console.log('true');
				$("#dateValues").text("");
			}

			blackoutDates.push(fromDate + ","+toDate);
			var formattedDate = getDateString(fromDate, toDate);
			console.log(formattedDate);
			var p = document.createElement("p");
			p.setAttribute("class", "date-inputted");
			p.setAttribute("value", formattedDate);
			var txt = document.createTextNode(formattedDate);
			p.appendChild(txt);
			$("#dateValues").append(p);
			$("#from-date-input").val("");
			$("#to-date-input").val("");
		}
	}

	function getDateString(fromDateStr, toDateStr) {
	    [fromYear, fromMonth, fromDay] = fromDateStr.split("-");
	    [toYear, toMonth, toDay] = toDateStr.split("-");
	    fromMonth = getMonth(fromMonth);
	    toMonth = getMonth(toMonth);
	    if(fromYear == toYear && fromMonth == toMonth)
	    	return fromMonth + " " + fromDay + " - " + toDay + ", " + fromYear;
	    else
	    	return fromMonth + " " + fromDay + ", " + fromYear + " - " + toMonth + " " + toDay + ", " + toYear
	}

	function submitBlackoutDates(){
		console.log(blackoutDates);
		for(var i = 0 ; i < blackoutDates.length; i++ ){
			[fromDate, toDate] = blackoutDates[i].split(",");
			// $.ajax({
			//   type: "POST",
			//   url: "admin/submitForm.php",
			//   data:{action:'submitBlackoutDates', congID: <?php echo $congID ?>,from: fromDate, to: toDate},
			//   error: function(){
			//     alert("There is an error with the submit");
			//     exit();
			//   }
			// });
		}
		//s = s.substring(0, s.indexOf('T'))
	}

	function getMonth(monthNumber){
		var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		return months[monthNumber - 1];
	}
</script>