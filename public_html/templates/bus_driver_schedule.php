<?php
	$page='RAHIN Home';
	$path_to_root="./../";
	require_once($path_to_root."../BUS/GeneralTemplate.class.php");
      $generalTemplate = new GeneralTemplate($page, $path_to_root);

      echo $generalTemplate->insertHeader();

      require_once($path_to_root."../BUS/schedule/BusDriverSchedule.class.php");
      $busDriverScheduler = new BusDriverSchedule($path_to_root, $page);
?>
<link rel="stylesheet" type="text/css" href="<?php echo $path_to_root ?>css/schedule.css">
<div id="schedule">
	<header>
		<h1>January 2018 - Bus Driver Schedule</h1>
	</header>
	<table>
		<tr>
			<td id="cong">Cong 1</td>
			<td>	1
            M:
            MB:
            E:
            EB:
			</td>
			<td>	2
            M:
            MB:
            E:
            EB:
			</td>
			<td>	3
            M:
            MB:
            E:
            EB:
			</td>
			<td>	4
            M:
            MB:
            E:
            EB:
			</td>
			<td>	5
            M:
            MB:
            E:
            EB:
			</td>
			<td>	6
            M:
            MB:
            E:
            EB:
			</td>
			<td>	7
            M:
            MB:
            E:
            EB:
			</td>
		</tr>
		<tr>
			<td id="cong">Cong 2</td>
			<td>	8
            M:
            MB:
            E:
            EB:
			</td>
			<td>	9
            M:
            MB:
            E:
            EB:
			</td>
			<td>	10
            M:
            MB:
            E:
            EB:
			</td>
			<td>	12
            M:
            MB:
            E:
            EB:
			</td>
			<td>	12
            M:
            MB:
            E:
            EB:
			</td>
			<td>	13
            M:
            MB:
            E:
            EB:
			</td>
			<td>	14
            M:
            MB:
            E:
            EB:
			</td>
		</tr>
		<tr>
			<td id="cong">Cong 3</td>
			<td>	15
            M:
            MB:
            E:
            EB:
			</td>
			<td>	16
            M:
            MB:
            E:
            EB:
			</td>
			<td>	17
            M:
            MB:
            E:
            EB:
			</td>
			<td>	18
            M:
            MB:
            E:
            EB:
			</td>
			<td>	19
            M:
            MB:
            E:
            EB:
			</td>
			<td>	20
            M:
            MB:
            E:
            EB:
			</td>
			<td>	21
            M:
            MB:
            E:
            EB:
			</td>
		</tr>
		<tr>
			<td id="cong">Cong 4</td>
			<td>	22
            M:
            MB:
            E:
            EB:
			</td>
			<td>	23
            M:
            MB:
            E:
            EB:
			</td>
			<td>	24
            M:
            MB:
            E:
            EB:
			</td>
			<td>	25
            M:
            MB:
            E:
            EB:
			</td>
			<td>	26
            M:
            MB:
            E:
            EB:
			</td>
			<td>	27
            M:
            MB:
            E:
            EB:
			</td>
			<td>	28
            M:
            MB:
            E:
            EB:
			</td>
		</tr>
		<tr>
			<td id="cong">Cong 5</td>
			<td>	29
            M:
            MB:
            E:
            EB:
			</td>
			<td>	30
            M:
            MB:
            E:
            EB:
			</td>
			<td>	31
            M:
            MB:
            E:
            EB:
			</td>
			<td>	1
            M:
            MB:
            E:
            EB:
			</td>
			<td>	2
            M:
            MB:
            E:
            EB:
			</td>
			<td>	3
            M:
            MB:
            E:
            EB:
			</td>
			<td>	4
            M:
            MB:
            E:
            EB:
			</td>
		</tr>
	</table>
</div>
<?php
	echo $generalTemplate->insertFooter();
?>