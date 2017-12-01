<?php
	/**
	 * Admin Generate Schedule page for RSA
	 * 
	 * @author     Chevy Mac
	 * @version    Release: 1.0
	 * @date       11/10/17
	 */
	 
	$page='RAIHN Admin Generate Schedule';
	$path_to_root="./../../";

	// Setting up template system and loads functions for Admin
	require_once($path_to_root.'../BUS/GeneralTemplate.class.php');
	require_once($path_to_root.'../BUS/admin/AdminFunctions.class.php');

	$generalTemplate = new GeneralTemplate($page, $path_to_root);
	$adminFunctions = new AdminFunctions($page, $path_to_root);
	
	// Inserting header and navigation onto page via template system
	echo $generalTemplate->insertHeader();
	echo '<link href="'.$path_to_root.'css/admin.css" rel="stylesheet">';

?>
	<div id="admin_container">
		<div id="generate">
			<table id ="generate_schedule">
				<tr>
					<th colspan="2" id="title">Rotation: 50</th>
				</tr>
				<tr>
					<td class="genDate">5/28/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">6/4/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">6/11/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">6/18/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">6/25/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">7/2/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">7/9/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">7/16/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">7/23/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">7/30/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">8/6/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">8/13/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>
				<tr>
					<td class="genDate">8/20/2017</td>
					<td class="genSche">Congregation 1</td>
				</tr>		
			</table>
			<div id="genBtnArea">
				<input type='button' class ='genBtn' name='re-gen' value='Re-Generate'><input type='button' id='genRight' class ='genBtn' name='save-send' value='Save / Send'>
			</div>
		</div>	
	</div>
<?php
	echo $generalTemplate->insertFooter();
?>