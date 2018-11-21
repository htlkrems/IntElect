<!doctype html>
<html>

<head>
@include('headdata')
<title>.:: IntElect - Trete dieser Umfrage bei ::.</title>
</head>

<body>
  @include('mainnav')
  <main class="container">
    <center>
      <div class="row">
	<h3>Einmalcode der Umfrage eingeben: </h3>
	<h1> {{ $poll->token }} </h1>
      </div>
      <div class="row">
	<h3>Oder QR-Code scannen:</h3>
       <?php QRCode::url(Request::root()."/inputToken?token=".$poll->token)->setSize(13)->svg(); ?>
      </div>
    </center>
  </main>
  @include('footer')
</body>
</html>
