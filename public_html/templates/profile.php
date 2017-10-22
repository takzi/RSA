<?php
	$page='RAHIN Profile';
	$path="./";
	require_once($path."header.php");
	echo '<link href="'$path.'../css/profile.css" rel="stylesheet">';
?>
<div class="container">
	<?php
		$role = "test";
		
		// Will check if user's role is admin, else it will display normal profile page.
		if($role == "admin")
		{
			echo '<h1 id ="profile_h1">Administrator Home</h1>';
		}
		else
		{
			echo '<h1 id ="profile_h1">Congegation Name</h1>';
		}
	?>
	<div id="profile_container">
		<div align="left">
		<?php
			if($role == "admin")
			{
				require_once($path.'templates/admin/profile.php');
			}
			else
			{
				$t1 = "test1";
				$t2 = "test";
				
				// If there is any action required, it will display ACTION REQUIRED in red, else it will show regular button with no actions to take.
				if ($t1 == "test") 
				{
					echo '	<button id ="required">ACTION REQUIRED</button>';
				}
				else
				{
					echo '	<button>No Action Required</button>';
				}
				echo '
				<br>
				<button>View/Request Blackout Dates</button>
				<br>
				<button>Request Schedule Change</button>';
				
				// If the profile is for bus driver, display the bus driver schedule, else it will display Congregation Schedule.
				if($t2 == "test")
				{
					require_once($path.'templates/bus_driver/profile.php');
				} 
				else 
				{
					require_once($path.'templates/congregation/profile.php');
				}
			}
		?>

<?php
	require_once($path."footer.php");
?>