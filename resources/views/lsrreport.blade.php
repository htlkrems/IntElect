<html>
<head>
<title>.:: IntElect - Report ::.</title>
</head>
<body>
	<h1>Ergebnisse: <?php echo $election->name;?></h1>
	<table border="1">
			<tr>
				<td><b>Punkte</b></td>
				<?php
					foreach ($electiongroups as $electiongroupname) {
						echo "<td>".$electiongroupname->name."</td>";
					}
				?>
				<td>Gesamt</td>
			</tr>
			<?php
				foreach ($candidates as $candidate) {
					echo "<tr>";
					echo "<td>".$candidate->name." ".$candidate->party."</td>";
					$overallpoints=0;
					foreach($electiongroups as $electiongroup){		
						echo "<td>";
						$output=0;
						foreach ($voteResults as $voteResult) {
							if($voteResult->can_id==$candidate->id && $voteResult->eleg_id==$electiongroup->id){
								$overallpoints=$overallpoints+$voteResult->gcpoints;
								$output+=$voteResult->gcpoints;
							}
						}
						echo $output;
						echo "</td>";
					}
					echo "<td>".$overallpoints."</td>";
					echo "</tr>";
				}
				echo "<tr><td></td></tr><tr><td></td></tr>";
				echo "<tr>";
				echo "<td><b>Gültige Stimmen</b></td>";
				$overallvalidvotes=0;
				foreach($electiongroups as $electiongroup){
					foreach ($validVotesPerGroup as $validVotes) {
						if($validVotes->eleg_id==$electiongroup->id){
							$overallvalidvotes+=$validVotes->countvalidvotes;
							echo "<td>";
							echo $validVotes->countvalidvotes;
							echo "</td>";
						}
					}
				}
				echo "<td>".$overallvalidvotes."</td>";
				echo "</tr>";
				if($election->type==1){
				echo "<tr><td></td></tr><tr><td><b>Anzahl der 6er Punkte</b></td></tr>";
				foreach ($candidates as $candidate) {
					echo "<tr>";
					echo "<td>".$candidate->name." ".$candidate->party."</td>";
					$overall6=0;
					foreach($electiongroups as $electiongroup){
						echo "<td>";
						$output=0;
						foreach ($voteResultssixPoints as $vrsixpoints) {
							if($vrsixpoints->can_id==$candidate->id && $vrsixpoints->eleg_id==$electiongroup->id){
								$overall6=$overall6+$vrsixpoints->sixpointscount;
								$output+=$vrsixpoints->sixpointscount;
							}
						}
						echo $output;
						echo "</td>";
					}
					echo "<td>".$overall6."</td>";
					echo "</tr>";
				}}
			?>
	</table>

	<?php 
	$titles = array(0=>'Schulsprecher', 1=>'1. Stellvertreter des Schulsprechers', 2=>'2. Stellvertreter des Schulsprechers', 3=>'1. Stellvertreter für den SGA', 4=>'2. Stellvertreter für den SGA', 5=>'3. Stellvertreter für den SGA', 6=>'4. Stellvertreter für den SGA');
	$counter=0;
	foreach ($winners as $winner) {

		echo "<p>".$titles[$counter]." :";

		foreach ($candidates as $candidate) {
			if($candidate->id==$winner->can_id){
				echo $candidate->name." ".$candidate->party;
			}
		}
		echo "</p>";
		$counter++;
	}
	?>
</body>
</html>
