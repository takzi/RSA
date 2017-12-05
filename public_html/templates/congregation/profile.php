<h1 id ="profile_h1"><?php echo $_SESSION['fullname']; ?></h1>
	<div id="profile_container">
		<div align="left">
			<a href="change_password.php"><button>Change Password</button></a>
			<br>
			<a href="blackout_dates_profile.php"><button>View/Request Blackout Dates</button></a>
			<br>
			<a href="email.php"><button>Request Schedule Change</button></a>
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

							if(($schedule = $congregationSchedule->insertCongregationScheduleById($_SESSION['id'])) == ""){
								$schedule = "No schedule available";
							}

							echo $schedule;
						?>
					</td>
				<tr>
			</table>
		</div>
	</div>
</div> 