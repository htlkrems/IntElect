<!doctype html>
<html>

<head>
@include('headdata')
<title>.:: IntElect - Anmelden ::.</title>
</head>
<body>

@include('mainnav')
  <main>
      <div class="container">
        <div class="row valign-wrapper">
	  <div class="col s12 m8 offset-m2 valign">
	    <div class="card grey lighten-5 hoverable center-align">
	      <div class="card-content">
		<span class="card-title">Melden Sie sich an!</span>
          	<form method="post" action="login" onsubmit="return validateform()">
	       	   <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	           <label for="username_id">Benutzername</label>
                   <input class='validate tovalidate' placeholder="Benutzername" type='text' name='username' id='username_id' autofocus required="" />
        	   <label for="password_id">Passwort</label>
		   <input class='validate' type='password' placeholder="Passwort" name='password' id='password_id' required="" />
        	   <button type='submit' name='btn_login' class='btn waves-light waves-effect'>Anmelden</button>
       		</form>
	      </div>
	    </div>
	  </div>
        </div>
      </div>
  </main>
@include('footer')
</body>

</html>
