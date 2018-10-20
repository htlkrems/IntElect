<html>
<head>
<title>.:: IntElect - Tokenliste {{$electionname[0]->name}} ::.</title>
</head>
<body>
	<table border="1" align="center">

		<thead>
			<tr><td><?php echo "Tokens für: Wahl - ".$electionname[0]->name." | Wahlgruppe - ".$election_group_name[0]->name;?></td></tr>
		</thead>
		<tbody>
		<?php
		$count=0;
		foreach ($tokens as $token) {
			echo "<tr><td>";
			echo "<br><br>";
			echo "Code eingeben unter ".Request::root()."/vote <br>";
			echo "<strong>".$token->token."</strong><br>";
			echo "</td></tr>";
			$count++;
			if($count>=12){
				$count=0;
				echo "<br><br><br><br><br>";
			}
		}
		?>
	</tbody>
	</table>
</body>
</html>
