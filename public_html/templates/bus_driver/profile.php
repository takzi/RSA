<h1 id ="profile_h1"><?php echo $_SESSION['fullname']; ?></h1>
	<div id="profile_container">
		<div align="left">
			<a href="change_password.php"><button>Change Password</button></a>
			<br>
			<a href="availability_dates_profile.php"><button>View/Request Availability Dates</button></a>
			<br>
			<a href="email.php"><button >Request Schedule Change</button></a>>
		</div>
		<div align="right"> 
			<table>
				<tr>
					<td colspan="3" id="title">Current Schedule</td>
				<tr>
						<?php 
							$page='Bus Driver Schedule';
							
							// Checks if there is schedule available
							require_once($path_to_root."../BUS/schedule/BusDriverSchedule.class.php");
	      						$busDriverScheduler = new BusDriverSchedule($path_to_root, $page);

							if(($schedule = $busDriverScheduler->insertInProgressBusDriverSchedulesById($_SESSION['id'])) == ""){
								$schedule = "<td>No schedule available</td>";
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