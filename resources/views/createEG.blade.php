 <html>
<head>
@include('headdata')
<title>.:: IntElect - Wahlgruppe erstellen ::.</title>
</head>
<body>
@include('adminnav')
  <main class="container">
    <div class="row">
        <h4>Wahlgruppe erstellen: </h4>
        <div class="divider"></div>
        <form class="col s12" method="post" action="{{route('admin.createElectionGroup')}}" onsubmit="return validateform()">
		    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="row">
                        <div class="input-field">
                            <label for="name">Name:</label>
                            <input type="text" class="validate tovalidate" name="name" required="" id="name">
                        </div>
                        <div class="input-field ">
                            <label for="numberofparticipants">Anzahl der Mitglieder:</label>
                            <input type="number" class="validate tovalidate" name="member_count" required="" id="numberofparticipants">
                        </div>
                        <div class="row">
                            <label>Wahlgruppenleiter:</label>
                            <?php
				$req=false;
                                foreach($users as $user => $id){
				echo '<p>
                                	<input name="users" type="radio" class="tovalidate" id="user_id'.$id.'" value="'.$id.'" ';
					if(!$req){ $req=true; echo 'required=""'; } echo ' />
                                	<label style="color: #000000" for="user_id'.$id.'">'.$user.'</label>
                                </p>';
                                }
                                ?>
                        </div>
                </div>
            <button class="btn waves-effect waves-light" type="submit" name="action">Erstellen</button>
		</form>
    </div>
</main>
@include('footer')
</body>
</html>
