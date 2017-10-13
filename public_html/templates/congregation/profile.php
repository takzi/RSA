<?php
	$page='RAHIN Home';
	$path="./../";
	require_once($path."header.php");
	echo '<link href="'.$path.'../css/profile.css" rel="stylesheet">';
?>

<div class="container">
	<h1 id ="profile_h1">Congegation Name</h1>
	<div id="profile_container">
		<div align="left"> 
			<button id ="red_button">ACTION REQUIRED</button>
			<br>
			<button id ="profile_button">View/Request Blackout Dates</button>
			<br>
			<button id ="profile_button">Request Schedule Change</button>
		</div>
		<div align="right"> 
			<table>
				<tr>
					<td id="title">Current Schedule</td>
				<tr>
				<tr>
					<td>January 1 - 8, 2017<br>January 1 - 8, 2017<br>January 1 - 8, 2017<br>January 1 - 8, 2017</td>
				<tr>
			</table>
		</div>
	</div>
</div> 
<?php
	require_once($path."footer.php");
?>