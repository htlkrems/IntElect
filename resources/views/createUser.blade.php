 <html>
<head>
@include('headdata')
<title>.:: IntElect - Benutzer erstellen ::.</title>
</head>
<body>
@include('mainnav')
  <main class="container">
    <div class="row">
        <h4>User erstellen: </h4>
        <div class="divider"></div>
        <form class="col s12" method="post" action="{{route('admin.createUser')}}" onsubmit="return validateform()">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
			<div class="row">
				<div class="input-field col s12">
					<label for="username_id">Benutzername</label>
                        		<input type="text" class="validate tovalidate" name="username" id="username_id" required="" id="username">
                        	</div>
			</div>
			<div class="row">
                                <div class="input-field col s12">
					<label for="password_id">Passwort</label>
					<input type="password" class="validate" name="password" required="" id="password_id">
				</div>
			</div>
			<div class="row">
                                <div class="input-field col s12">
					<h5>Rolle:</h5>
        	                        <p>
                    	                	<input name="type" type="radio" id="type_id1" value="0" class="role_picker" required="" />
                            	        	<label for="type_id1" style="color: #000000">Wahlgruppenleiter</label>
                            		</p>
                            		<p>
                                		<input name="type" type="radio" id="type_id2" value="1" class="role_picker" />
                                		<label for="type_id2" style="color: #000000">Administrator</label>
                            		</p>
				</div>
			</div>
			<div class="row" id="electiongroupbox" style="display:none">
 	                       <div class="input-field col s12">
        	                    <h5>Wahlgruppen:</h5>
                           <?php
                                foreach($electiongroups as $electiongroup){ ?>
                                    <div class="row">
                                        <input type="checkbox" id="{{$electiongroup->id}}" name="election_groups[{{$electiongroup->id}}]" value="{{$electiongroup->name}}" class="col 12"><label for="{{$electiongroup->id}}">{{$electiongroup->name}}<br><br>
                                    </div><?php
                                }
                                ?>
				</div>
                        </div>
            <button class="btn waves-effect waves-light" type="submit" name="action">Erstellen</button>
		</form>
    </div>
</main>
@include('footer')
<script>
$( document ).ready(function() {
     $('.role_picker').change( function() {
     if(document.getElementById('type_id1').checked) {
  document.getElementById('electiongroupbox').style.display = 'block';
}else if(document.getElementById('type_id2').checked) {
  document.getElementById('electiongroupbox').style.display = 'none';
}
});
});
</script>
</body>
</html>
