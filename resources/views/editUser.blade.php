 <html>
    <head>
        @include('headdata')
        <title>.:: IntElect - {{$user->username}} bearbeiten ::.</title>
    </head>
    <body>
        @include('mainnav')
        <main class="container">
            <div class="row">
                <h4>User bearbeiten: {{$user->username}}</h4>
                <div class="divider"></div>
                <form class="col s12" method="post" action="{{route('Admin.editUser')}}" onsubmit="return validateform()">
		            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="user_id" value="{{$user->id}}"
                    <div class="row">
                        <div class="input-field  col s12">
                            <label for="username">Username:</label>
                            <input type="text" class="validate tovalidate" name="username" required="" id="username" value="{{$user->username}}">
                        </div>
                        <div class="input-field col s12">
                            <label for="password">Passwort (leer lassen für unverändert):</label>
                            <input type="password" class="validate" name="password" id="password">
                        </div>
			<?php
			  if($user->type==0){ ?>
                        <div class="col 12">
                            <p>Wahlgruppen</p>
                            <?php
                                foreach($electiongroups as $electiongroup){ ?>
                                    <div class="row"> <?php
                                    if($electiongroup->user_id==$user->id){
                                    ?>

                                        <input type="checkbox" id="{{$electiongroup->id}}" checked="checked" name="election_groups[{{$electiongroup->id}}]" value="{{$electiongroup->name}}" class="col s12"><label for="{{$electiongroup->id}}">{{$electiongroup->name}}<br><br>
                                    <?php
                                    } else {
                                    ?>
                                        <input type="checkbox" id="{{$electiongroup->id}}" name="election_groups[{{$electiongroup->id}}]" value="{{$electiongroup->name}}" class="col 12"><label for="{{$electiongroup->id}}">{{$electiongroup->name}} (dezeitiger Leiter: {{$electiongroup->username}})<br><br>
                                    <?php } ?></div><?php
                                }
                                ?>
                        </div>
			<?php } ?>
                </div>
            <button class="btn waves-effect waves-light" type="submit" name="action">Erstellen</button>
		</form>
    </div>
</main>
@include('footer')
</body>
</html>
