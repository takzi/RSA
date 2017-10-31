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
						January 1 - 8, 2017
						<br><br>
						January 1 - 8, 2017
						<br><br>
						January 1 - 8, 2017
						<br><br>
						January 1 - 8, 2017
					</td>
				<tr>
			</table>
		</div>
	</div>
</div> 