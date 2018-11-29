<!doctype html>
<html>
<head>
@include('headdata')
<title>.:: IntElect - Einmalcode eingabe ::.</title>
</head>
<body>
@include('mainnav')
    <main class="container">
      <div class="row valign-wrapper">
        <div class="col s12 m8 offset-m2 valign">
          <div class="card hoverable center-align">
            <div class="card-content">
              <span class="card-title">Geben Sie Ihren Einmalcode ein!</span>
              <form method="post" action="{{route('Poll.inputToken')}}" onsubmit="return validateform()">
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                  <input type="text" placeholder="Token eingeben" id="token" class="validate tovalidate" name="token" required="">
                <button class="btn waves-effect waves-light" type="submit" name="action">Absenden</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </main>
    @include('footer')
  </body>
</html>
