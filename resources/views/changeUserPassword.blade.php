 <!doctype html>
    <html>
        <head>
	   <title>.:: IntElect - Passwort ändern ::.</title>
            @include('headdata')
        </head>
        <body>
            @include('mainnav')
            <div class="container">
                <div class="container">
                <div class="row">
                    <h2>
                        Passwort ändern: {{$user->username}}
                    </h2>
                    <div class="divider"></div>
                    <form class="col s12" method="post" action="{{route('Home.changePassword')}}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="userid" value="{{$user->id}}">
                        <input type="hidden" name="username" value="{{$user->username}}">
                        <div class="row">
                            <div class="input-field col s12">
				<label for="password_id">Altes Password</label>
                                <input id="password_id" type="password" name="password" class="validate" required="">
                            </div>
                            <div class="input-field col s12">
				<label for="newpassword_id">Neues Passwort</label>
                                <input id="newpassword_id" name="newpassword" type="password" class="validate" required="">
                            </div>
                            <div class="input-field col s12">
				<label for="newpasswordconfirm_id">Neues Passwort bestätigen</label>
                                <input id="newpasswordconfirm_id" name="newpasswordconfirm" type="password" class="validate" required="">
                            </div>
                            <div class="input-field col s12">
                                 <button class="btn waves-effect waves-light" type="submit" name="action">
                                    Bestätigen der Änderungen
                                 </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </body>
    </html>
        
