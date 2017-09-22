<!--
<style>
input[type=text], input[type=password] 
{
    width: 445px;
    padding: 12px 20px;
    margin-left: 25px;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

h2
{
	margin-top: 0px;
	background-color: #0E6AA8;
    color: white;
    text-align: center;
    height: 80px;
    font-size: 65px;
    width: 500px;
}

button 
{
    background-color: #0E6AA8;
    font-size: 30px;
    color: white;
    padding: 14px 20px;
	margin-left: 25px;
	margin-bottom: 10px;
    border: none;
    cursor: pointer;
    width: 450px;
    
}

button:hover 
{
    opacity: 0.8;
}

.container 
{
	margin-top: 35px;
	margin-bottom: 35px;
    margin-right:auto; 
    margin-left:auto;
    width: 500px;
	border: 3px solid #A9A9A9;
}

</style>
-->
<?php
	$page='RAHIN Login';
	$path="./";
	include($path."./templates/header.php");
?>
<!--
	include($path."./templates/nav.php");
-->
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
	include($path."./templates/footer.php");
?>