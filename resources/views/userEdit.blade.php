 <!doctype html>
	<html>
		<head>
			@include('headdata')
			<title>.:: IntElect - Profil bearbeiten ::.</title>
			<script>
         		$(document).ready(function() {
            		$('select').material_select();
        		 });
	      		</script>
		</head>
		<body>
			@include('mainnav')
			<main class="container">
				<h2>
					{{$user->username}} bearbeiten
				</h2>
				<div class="divider"></div>
				<form class="col s12" method="post" action="{{URL::to('editUser')}}" enctype="multipart/form-data" onsubmit="return validateform()">
					<div class="row">
						<div class="col s12">
        					<input id="username" name="username" type="text" class="validate tovalidate" required="" value="{{$user->username}}">
        					<label for="username">Name</label>
        				</div>
        				<div class="col s12">
        					<input id="newpassword" name="newpassword" type="password" class="validate" required="">
        					<label for="newpassword">Neues Passwort</label>
        				</div>
        				<div class="col s12">
        					<input id="newpasswordconfirm" name="newpasswordconfirm" type="password" class="validate" required="">
        					<label for="newpasswordconfirm">Neues Passwort bestätigen</label>
        				</div>
        				<div class="col s12">
        					<select name="electionselect" class='tovalidate' required="" id="selectElectionsGroupsUser" multiple="">
                                <?php
                                	foreach($electiongroups as $electiongroup){
                                   		echo "<option value=\"".$election->id."\">".$election->name."</option>";
                                }
                                ?>
                            </select>
        				</div>
					</div>
				</form>
			</main>
			@include('footer')
		</body>
	</html>
