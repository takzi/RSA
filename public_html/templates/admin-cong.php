<?php
	$page='RAHIN Admin Congregation';
	$path="./";
	require_once($path."header.php");
	echo '<link href="'$path.'../css/admin.css" rel="stylesheet">';
?>
<div class="container">
	<div id="adminLink">
		<a href="#">Admin Home</a> > <a href="#">Congregation</a>
	</div>
	<h1>Congregation</h1>
	<div id="admin_container">
		<div align="left">
		<input type="text" name="congregation" value="Congregation Name"> <input type="button" value="Add Now">
		<input type="button" value="Generate New Schedule"><input type="button" value="View Current Schedule">
		<table>
			<tr>
				<td>Congregation 1 <input type="button" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>
			<tr>
				<td>Congregation 2 <input type="button" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>
			<tr>
				<td>Congregation 3 <input type="button" value="Edit"><input type="button" value="Reset Password"></td>
			</tr> 
			<tr>
				<td>Congregation 4 <input type="button" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>
			<tr>
				<td>Congregation 5 <input type="button" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>
			<tr>
				<td>Congregation 6 <input type="button" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>    
			<tr>
				<td>Congregation 7 <input type="button" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>   
		</table>
	</div>
<?php
	require_once($path."footer.php");
?>