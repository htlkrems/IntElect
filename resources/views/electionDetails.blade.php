<!doctype html>
	<html>
		<head>
			@include('headdata')
			<title>.:: IntElect - {{$election->name}} ::.</title>
			<script>
				$(document).ready(function(){
    				$('ul.tabs').tabs();
    				 $('.modal').modal();
    				$('.datepicker').pickadate({
					    selectMonths: true,
					    selectYears: 15,
					    today: 'Today',
					    clear: 'Clear',
					    close: 'Ok',
					    closeOnSelect: false,
					    format: 'yyyy-mm-dd'
					});
  				});
			</script>
		</head>
		<body>
			@include('adminnav')
			<div class="container">
				<div class="row">
					<h3>Wahldetails: {{$election->name}}</h3>
					<div class="col s12">
						<ul class="tabs" swipeable="true">
							<li class="tab col s4">
								<a href="#detailsTab">Details</a>
							</li>
							<li class="tab col s4">
								<a href="#electionGroupsTab">Wahlgruppen</a>
							</li>
							<li class="tab col s4">
								<a href="#candidatesTab">Kandidaten</a>
							</li>
						</ul>
					</div>
					<div id="electionGroupsTab" class="col s12">
						<div class="row">
							<div class="col s12">
								<table class="highlight">
									<thead>
										<th>Name</th>
										<th>Gruppenleiter</th>
										<th>Mitgliederanzahl</th>
										<th>Optionen</th>
									</thead>
									<tbody>
							<?php 
								foreach ($electiongroupsinelection as $egie) {
									?><tr>
										<td>{{$egie->ename}}</td>
										<td>{{$egie->uname}}</td>
										<td>{{$egie->emember_count}}</td>
										<td>
											<a href=<?php echo route('admin.showEGEdit',['election_group_id'=>$egie->eid]);?> style="color: black;">
                                                    <i class="small material-icons">edit</i>
                                            </a>
                                            <a href=<?php echo route('Admin.removeEG',['election_id'=>$election->id,'election_group_id'=>$egie->eid]);?> style="color: black;">
                                                    <i class="small material-icons">delete</i>
                                            </a>
										</td></tr>
									<?php
								}?>
							</tbody>
						</table>
							</div>
						</div>
						<a class="waves-effect waves-light btn modal-trigger" href="#modal1">Wahlgruppen hinzufügen</a>

						<div id="modal1" class="modal bottom-sheet">
						    <div class="modal-content">
						    <h4>Wahlgruppen hinzufügen</h4>
						    <form method="post" action="{{route('Admin.addEG')}}" onsubmit="return validateform()">
						    	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
						    	<input type="hidden" class='tovalidate' name="election_id" value="{{$election->id}}">
						    	<div class="row">
						    <?php 
						    	foreach ($electiongroupsnotinelection as $egnie) {		
						    		if(count($electiongroupsinelection)>0){
						    		foreach ($electiongroupsinelection as $egie) {
						    			if($egie->eid!=$egnie->eid&&count($electiongroupsinelection)!=count($electiongroupsnotinelection)){
						      	?>
							      	<div class="input-field col s12">
							      		<input type="checkbox" id="{{$egnie->eid}}" class='tovalidate' name="election_groups[]" value="{{$egnie->eid}}" class="col s12"><label for="{{$egnie->eid}}">{{$egnie->ename}}</label>
							      	</div>
						      	<?php	
						     		}
						 		}}else{
						 			?>
							      	<div class="input-field col s12">
							      		<input type="checkbox" id="{{$egnie->eid}}" class='tovalidate' name="election_groups[]" value="{{$egnie->eid}}" class="col s12"><label for="{{$egnie->eid}}">{{$egnie->ename}}</label>
							      	</div>
						      	<?php
						 		}}
						      ?></div>
						      <button class="btn waves-effect waves-light" type="submit" name="action">Übernehmen</button>
						  	</form>
						    </div>
						    <div class="modal-footer">
						      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Abbrechen</a>
						    </div>
						</div>
					</div>
					<div id="candidatesTab" class="col s12">
						<div class="row">
							<div class="col s12">
								<table class="highlight">
									<thead>
										<th>Name</th>
										<th>Partei</th>
										<th>Bearbeiten</th>
										<th>Entfernen</th>
									</thead>
									<tbody>
								<?php 
								foreach ($candidates as $candidate) {
								?><tr>
									<div class="row">
									<form method="post" action="{{route('Admin.editElectionCandidate')}}" onsubmit="return validateform()">
										<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	    								<input type="hidden" name="candidateid" value="{{$candidate->id}}">
										<td><div class="input-field">
					                            <label for="c_name">Name</label>
					                            <input type="text" class="validate tovalidate" name="c_name" required="" id="c_name" value="{{$candidate->name}}">
					                     </div></td>
					                     <td><div class="input-field">
					                            <label for="c_party">Partei</label>
					                            <input type="text" class="validate tovalidate" name="c_party" required="" id="c_party" value="{{$candidate->party}}">
					                     </div></td>
					                     <td>
					                            <button class="btn waves-effect waves-light" type="submit" name="action">Übernehmen</button>
					                     </td>
									</form>
									<form method="post" action="{{route('Admin.removeCandidate')}}">
											<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
											<input type="hidden" name="candidate_id" value="{{$candidate->id}}">
											<input type="hidden" name="election_id" value="{{$election->id}}">
											<td><button class="btn waves-effect waves-light" type="submit" name="action">Entfernen</button></td>
									</form>
								</div></tr>
								<?php
								}
								?></tbody></table>
							</div>
						</div>
					</div>
					<div id="detailsTab" class="col s12">
						<div class="row">
							<form class="col s12" method="post" action="{{route('Admin.editElection')}}" onsubmit="return validateform()">
	    						<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	    						<input type="hidden" name="electionid" value="{{$election->id}}">
            					<div class="row">
                					<div class="col s12">
                    					<div class="row">
					                        <div class="input-field col s12">
					                            <label for="name_id">Name</label>
					                            <input type="text" class="validate tovalidate" name="e_name" required="" id="e_name" value="{{$election->name}}">
					                        </div>
					                        <div class="input-field col s12">
					                            <label for="description_id">Beschreibung</label>
					                            <textarea id="description_id" class="materialize-textarea tovalidate" name="e_description" placeholder="Beschreibung">{{$election->description}}</textarea>
					                        </div>
                    					</div>
                					</div>
                					<div class="col s12">
                    					<div class="row">
                        					<div class="input-field col s12">
                        						<h5>Registrierungszeit</h5>
                            					<input type="text" class="datepicker" id="crb" name="e_candidate_registration_begin" value="{{$election->candidate_registration_begin}}" placeholder="Von: ">
                            					<input type="text" class="datepicker" id="cre" name="e_candidate_registragion_end" value="{{$election->candidate_registragion_end}}" placeholder="Bis: ">
                            				</div>
			    						<div class="input-field col s12">
			    							<h5>Wahlzeit</h5>
                            					<input type="text" class="datepicker" id="eb" name="e_election_begin" value="{{$election->election_begin}}" placeholder="Von: ">
                            					<input type="text" class="datepicker" id="ee" name="e_election_end" value="{{$election->election_end}}" placeholder="Bis: ">
                        				</div>
		   								<div class="row">
					                        <div class="input-field col s12">
					                            <h5><i class="material-icons">settings</i> Wahlsystem</h5>
					                            <?php 
					                            	if($election->type==1){
					                            		?>
					                            			<p>
								                                <input name="e_type" class='tovalidate' type="radio" id="type_id1" value="1" checked="true" />
								                                 <label for="type_id1" style="color: #000000">Punktesystem</label>
					                            			</p>
								                            <p>
								                                <input name="e_type" type="radio" class='tovalidate' id="type_id2" value="0" />
								                                <label for="type_id2" style="color: #000000">Kreuzsystem</label>
								                            </p>
					                            		<?php
					                            	} else {
					                            		?>
					                            			<p>
								                                <input name="e_type" type="radio" class='tovalidate' id="type_id1" value="0" />
								                                 <label for="type_id1" style="color: #000000">Punktesystem</label>
					                            			</p>
								                            <p>
								                                <input name="e_type" type="radio" class='tovalidate' id="type_id2" value="1" checked="true" />
								                                <label for="type_id2" style="color: #000000">Kreuzsystem</label>
								                            </p>
					                            		<?php
					                            	}
					                            		?>
					                        </div>
		   								</div>
                    				</div>
                				</div>
            					<button class="btn waves-effect waves-light" type="submit" name="action">Übernehmen</button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</body>
	</html>
