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
				echo "</table><h1>Gültige Stimmen</h1>";?><table border="1"><?php
				echo "<tr><td><b>Gültige Stimmen</b></td>";
				foreach($electiongroups as $electiongroup){
					echo "<td>".$electiongroup->name."</td>";
				}
				echo "<td>Gesamt</td></tr><tr>";
				echo "<td>Anzahl</td>";
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
				echo "</table>";
				if($election->type==1){
				?><h1>Anzahl der 6er Punkte</h1><table border="1"><?php echo "<tr><td><b>Anzahl der 6er Punkte</b></td>";
				foreach($electiongroups as $electiongroup){
					echo "<td>".$electiongroup->name."</td>";
				}
				echo "<td>Gesamt</td></tr>";
				$all6points=0;
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
					$all6points=$all6points+$overall6;
				}
				echo "</table>";
				?>
					<p>Als Schulsprecher ist gewählt, wer auf größer 50% der vergebenen Stimmen 6er-Punkte erhalten hat. Das wären in diesem Fall <?php  echo $all6points/2;?> 6er-Stimmen.</p>
					<?php
			}elseif ($election->type==2) {
					
				?><h1>Anzahl der 2er Punkte</h1><table border="1"><?php echo "<tr><td><b>Anzahl der 2er Punkte</b></td>";
				foreach($electiongroups as $electiongroup){
					echo "<td>".$electiongroup->name."</td>";
				}
				echo "<td>Gesamt</td></tr>";
				$all6points=0;
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
					$all6points=$all6points+$overall6;
				}
				echo "</table>";
				?>
					<p>Als Abteilungssprecher ist gewählt, wer auf größer 50% der vergebenen Stimmen 2er-Punkte erhalten hat. Das wären in diesem Fall <?php  echo $all6points/2;?> 2er-Stimmen.</p>
					<?php
				}elseif ($election->type==3) {
				?><h1>Anzahl der 2er Punkte</h1><table border="1"><?php echo "<tr><td><b>Anzahl der 2er Punkte</b></td>";
				foreach($electiongroups as $electiongroup){
					echo "<td>".$electiongroup->name."</td>";
				}
				echo "<td>Gesamt</td></tr>";
				$all6points=0;
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
					$all6points=$all6points+$overall6;
				}
				echo "</table>";
					?>
					<p>Als Klassensprecher ist gewählt, wer auf größer 50% der vergebenen Stimmen 2er-Punkte erhalten hat. Das wären in diesem Fall <?php  echo $all6points/2;?> 2er-Stimmen.</p>
					<?php
				}
			?>
	<h1>Rollenverteilung</h1>
	<?php 
	$titles = array(0=>'Schulsprecher', 1=>'1. Stellvertreter des Schulsprechers', 2=>'2. Stellvertreter des Schulsprechers', 3=>'1. Stellvertreter für den SGA', 4=>'2. Stellvertreter für den SGA', 5=>'3. Stellvertreter für den SGA', 6=>'4. Stellvertreter für den SGA');
	$titles2=array(0=>'Abteilungssprecher', 1=>'Abteilungssprecher-Stellvertreter');
	$titles3=array(0=>'Klassensprecher',1=>'Klassensprecher-Stellvertreter');
	$counter=0;
	foreach ($winners as $winner) {
		echo "<p><b>".$titles[$counter].":</b> ";
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
