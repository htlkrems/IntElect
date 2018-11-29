
<!doctype html>
<html>

<head>
@include('headdata')
<title>.:: IntElect - Warten auf Beginn ::.</title>
</head>

<body>
  @include('mainnav')
  <main class="container">
    	  <div class="row">
		<center>
		<h2>{{ $poll->title }}</h2>
		<h3>Bitte warten Sie, bis die Umfrage gestartet ist!</h3>
<br><br><br><br><br><br>
<div class="preloader-wrapper big active" id="spinner">
      <div class="spinner-layer spinner-blue">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-red">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-yellow">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-green">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
    </div>
<br>
		  <button id="reloadButton" style="display:none;" class="btn waves-effect waves-light" type="submit" disabled="true" onClick="window.location.reload()" name="action">Weiter zur Umfrage
		    <i class="material-icons right">send</i>
          	  </button>
		</center>
      </div>
  </main>
  @include('footer')
</body>

<script>
	var token = <?php echo json_encode($poll->token) ?>;
         setInterval(function(){
	$.get("/polls/"+token+"/isStarted", function(data, status){
	    if(data.isStarted){
	        document.getElementById("spinner").style.display = 'none';
                document.getElementById("reloadButton").disabled = false;
	        document.getElementById("reloadButton").style.display = 'block';
	    }
    });
	 }, 2000);
    </script>
</html>
