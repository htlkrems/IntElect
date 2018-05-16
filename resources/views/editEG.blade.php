<html>
<head>
    @include('headdata')
    <title>.:: IntElect - Wahlgruppe bearbeiten ::.</title>
</head>
<body>
@include('adminnav')
<div class="container">
    <div class="row">
        <h4>Wahlgruppe bearbeiten: </h4>
        <div class="divider"></div>
        <form class="col s12" method="post" action="{{route('admin.editEG')}}" onsubmit="return validateform()">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	    <input type="hidden" name="id" value="{{$electiongroup->id}}">
            <div class="row">
                <div class="input-field">
                    <label for="name">Name:</label>
                    <input type="text" class="validate tovalidate" name="name" required="" id="name" value="{{$electiongroup->name}}">
                </div>
                <div class="input-field ">
                    <label for="numberofparticipants">Anzahl der Mitglieder:</label>
                    <input type="number" class="validate tovalidate" name="numberofparticipants" required="" id="numberofparticipants" value="{{$electiongroup->member_count}}">
                </div>
                <div class="row">
                    <label>Wahlgruppenleiter:</label>
                    <?php
                         $req=false;
                         foreach($users as $user){
                         echo '<p>
                               <input name="user_id" type="radio" class="tovalidate" id="user_id'.$user->id.'" value="'.$user->id.'" ';
                               if(!$req){ $req=true; echo 'required=""'; } if(!is_null($electiongroup->user_id)&&$user->id==$electiongroup->user_id){ echo ' checked';} echo ' />
                                  <label style="color: #000000" for="user_id'.$user->id.'">'.$user->username.'</label>
                           </p>';
                         }
                    ?>
                </div>
            </div>
            <button class="btn waves-effect waves-light" type="submit" name="action">Bearbeiten</button>
        </form>
    </div>
</div>
</body>
</html>
