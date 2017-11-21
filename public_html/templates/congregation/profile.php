<h1 id ="profile_h1"><?php echo $_SESSION['fullname']; ?></h1>
	<div id="profile_container">
		<div align="left">
			<?php
				$actionRequired = 1;
				// If there is any action required, it will display ACTION REQUIRED in red, else it will show regular button with no actions to take.
				if ($actionRequired == 1){
					echo '<button id ="required">ACTION REQUIRED</button>';
				} else {
					echo '<button>No Action Required</button>';
				}
			?> 	
			<br>
			<button>View/Request Blackout Dates</button>
			<br>
			<button>Request Schedule Change</button>
		</div>

		<div align="right"> 
			<table>
				<tr>
					<td id="title">Current Schedule</td>
				<tr>
				<tr>
					<td id ="cong_tb">
						<?php 
							$page='Congregation Schedule';
							
							// Checks if there is schedule available
							require_once($path_to_root.'../BUS/schedule/CongregationSchedule.class.php');
							$congregationSchedule = new CongregationSchedule($path_to_root, $page);
							//echo 'ID: ' . $_SESSION['id'];
							if(($schedule = $congregationSchedule->insertCongregationScheduleById($_SESSION['id'])) == ""){
								$schedule = "No schedule available";
							}

							echo $schedule;
						?>
<!-- 
						January 1 - 5, 2017
						<br><br>
						January 1 - 6, 2017
						<br><br>
						January 1 - 7, 2017
						<br><br>
						January 1 - 9, 2017 -->
					</td>
				<tr>
			</table>
		</div>
	</div>
</div> 