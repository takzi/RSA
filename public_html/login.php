<!--
<style>
form 
{
    border: 3px solid #F1F1F1;
}

input[type=text], input[type=password] 
{
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
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
    height: 60px;
    font-size: 50px;
}

button 
{
    background-color: #0E6AA8;
    font-size: 30px;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover 
{
    opacity: 0.8;
}

.container 
{
    padding: 16px;
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
<h2>RSA Login</h2>
	<div class="container">

		<label><b>Username</b></label>
		<input type="text" placeholder="Enter Username" name="username" required>

		<label><b>Password</b></label>
		<input type="password" placeholder="Enter Password" name="pw" required>
        
		<button type="submit">Login</button>
		<button type="submit">Request Account</button>
	</div>
</form>
<?php
	include($path."./templates/footer.php");
?>