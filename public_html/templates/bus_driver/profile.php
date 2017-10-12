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
			<button id ="profile_button">Action Required</button>
			<button id ="profile_button">View/Request Blackout Dates</button>
			<button id ="profile_button">Request Schedule Change</button>
		</div>
		<div align="right"> 
			<table>
				<tr>
					<td colspan="3" id="title">Current Schedule</td>
				<tr>
				<tr>
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
				<tr>
			</table>
		</div>
	</div>
</div> 
<?php
	require_once($path."footer.php");
?>