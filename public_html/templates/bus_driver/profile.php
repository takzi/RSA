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
					<td colspan="3" id="title">Current Schedule</td>
				<tr>
						<?php 
							$page='Bus Driver Schedule';
							require_once($path_to_root."../BUS/schedule/BusDriverSchedule.class.php");
	      						$busDriverScheduler = new BusDriverSchedule($path_to_root, $page);
							echo 'ID: ' . $_SESSION['id'];
							if(($schedule = $busDriverScheduler->insertInProgressBusDriverSchedulesById($_SESSION['id'])) == ""){
								$schedule = "No schedule available";
							}

							echo $schedule;
						?>
			<!-- 	<tr>
					<td>Jan 8</td>
					<td>M</td>
					<td>Congegation</td>
				<tr>
				<tr>
					<td>Jan 9</td>
					<td>E</td>
					<td>Congegation</td>
				<tr>
				<tr>
					<td>Jan 10</td>
					<td>MB</td>
					<td>Congegation</td>
				<tr>
				<tr>
					<td>Jan 11</td>
					<td>EB</td>
					<td>Congegation</td>
				<tr> -->
			</table>
		</div>
	</div>
</div> 