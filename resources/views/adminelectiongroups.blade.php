<html>
	<head>
		@include('headdata')
		<title>.:: IntElect - Wahlgruppen ::.</title>
	</head>
	<body>
		@include('adminnav')
		<div class="container">
		    <div class="row">
		    	<div class="col s12">
		    		<h3 class="col s11">Wahlgruppen</h3>
		    		<h3 class="col s1">
		    			<a href=<?php echo route('admin.showEGCreate');?> style="color: black;">
		    				<i class="small material-icons">add_circle</i>
		    			</a>
		    		</h3>
		    		<table class="highlight">
						<thead>
							<th>Name</th>
							<th>Gruppenleiter</th>
							<th>Mitgliederanzahl</th>
							<th>Zugeteilte Wahlen</th>
							<th>Optionen</th>
						</thead>
						<tbody>
							<?php
								foreach ($electiongroups as $electiongroup) {
									?>
									<tr>
										<td>{{$electiongroup->name}}</td>	
										<td>{{$electiongroup->uname}}</td>								
										<td>{{$electiongroup->member_count}}</td>
										<td>
											<?php
												foreach ($electionegs as $electioneg) {
													if($electioneg->election_group_id==$electiongroup->egid){
														echo "$electioneg->election_name ";
													}	
												}
											?>
										</td>	
										<td>
											<a href=<?php echo route('admin.showEGEdit',['egid'=>$electiongroup->id]);?> style="color: black;">
												<i class="small material-icons">create</i>
											</a>
											<a href=<?php echo route('admin.deleteEG',['egid'=>$electiongroup->id]);?> style="color: black;">
												<i class="small material-icons">delete</i>
											</a>
										</td>
									</tr>
									<?php

								}
							?>
						</tbody>
		    		</table>
		    	</div>
			</div>
		</div>
	</body>
</html>
