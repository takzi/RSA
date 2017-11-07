<?php
	$page='RAHIN Admin Congregation';
	$path_to_root="./../";
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	$generalTemplate = new GeneralTemplate($page, $path_to_root);

	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/admin.css" rel="stylesheet">';
?>
	<div id="adminLink">
		<a href="#">Admin Home</a> > <a href="#">Congregation</a>
	</div>
	<h1>Congregation</h1>
	<div id="admin_container">
		<div id="form">
		<input type="text" id="text" name="congregation" value="Congregation Name"> <input type="button" value="Add Now">
		<input type="button" id="right" value="Generate New Schedule"><input type="button" value="View Current Schedule">
		</div>
		<table>
			<tr>
				<td>Congregation 1 <input type="button" id="tb-right" name="Congregation 1" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>
			<tr>
				<td>Congregation 2 <input type="button" id="tb-right" name="Congregation 2" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>
			<tr>
				<td>Congregation 3 <input type="button" id="tb-right" name="Congregation 3" value="Edit"><input type="button" value="Reset Password"></td>
			</tr> 
			<tr>
				<td>Congregation 4 <input type="button" id="tb-right" name="Congregation 4" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>
			<tr>
				<td>Congregation 5 <input type="button" id="tb-right" name="Congregation 5" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>
			<tr>
				<td>Congregation 6 <input type="button" id="tb-right" name="Congregation 6" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>    
			<tr>
				<td>Congregation 7 <input type="button" id="tb-right" name="Congregation 7" value="Edit"><input type="button" value="Reset Password"></td>
			</tr>   
		</table>
<?php
	echo $generalTemplate->insertFooter();
?>