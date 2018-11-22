<!doctype html>
<html>
  <head>
    @include('headdata')
    <title>.:: IntElect - Wahlgruppenleiter ::.</title>
  </head>
<body>
  @include('mainnav')
  <div class="container">
  	<div class="row">
  		<h4>{{$poll->title}}</h4>
  		<div class="divider"></div>
  		<form class="col s12" method="post" action="{{route('Poll.assess',['poll_id'=>$poll->token])}}" id="pollFormID">
  			<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
  			<div class="row">
  			<?php 
  			foreach($options as $option){ ?>
  				<div class="card grey lighten-4">
  					<div class="card-content">
  							<span class="card-title">{{$option->text}}</span>
  								<p class="range-field">
                 				<input type="range" min="0" class='tovalidate pollpointInput' max="10" name="points[{{$option->id}}]" id="maxp{{$option->id}}"/>
                 				<center><output for="maxp{{$option->id}}" class="output"></output></center>
             					</p>
  						</div>
  					</div>
  			<?php }
  			
  			?><center><button class="btn waves-effect waves-light" type="submit" name="action">Absenden</button></center>
  		</form>
  	</div>
  </div>
</body>
</html>
