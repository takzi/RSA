<?php
	$page='RAHIN Home';
	$path="./";
	include("header.php");
?>

<!-- The login form should only appear if the user has not logge din yet. Otherwise, we can show some basic information. -->
<form action="">
	<div class="container">
	<form action="">
	<h2>RSA Login</h2>

		<input type="text" placeholder="Enter Username" name="username" required>
		<br><br>
		<input type="password" placeholder="Enter Password" name="pw" required>
        <br><br>
		<button type="submit">Login</button>
		<button type="submit">Request Account</button>
	</form>
	</div>
<?php
	include("footer.php");
?>