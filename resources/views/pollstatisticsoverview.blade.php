<!doctype html>
<html>

<head>
@include('headdata')
<title>.:: IntElect - Poll Overview ::.</title>
</head>
<body>
  @include('mainnav')
  <main class="container">
      <div class="row">
     <h4>Umfragen
     <a href="{{route('Poll.showCreatePollView')}}" style="color: black;float: right;">
        <i class="small material-icons">add_circle</i>
     </a></h4> 	
</div>
</div>
</div>
<div class="row">
     <?php 
      foreach ($polls as $poll) {
        ?>

        <div class="col s12 m4">
      <div class="card grey lighten-4 small">
        <div class="card-content black-text">
          <span class="card-title black-text">{{$poll->title}}</span>
	  <div class="divider"></div>
          <p>{{$poll->description}}</p>
        </div>
         <div class="card-action valign-wrapper">
          <a href="{{route('Poll.showPollStatistics',['poll_id'=>$poll->token])}}" class="valign-wrapper"><i class="material-icons">insert_chart</i></a>
          <a href="{{route('Poll.deletePoll',['poll_id'=>$poll->token])}}" class="right valign-wrapper"><i class="material-icons">delete</i></a>
	  <a href="{{route('Poll.showUpdatePollView',['poll_id'=>$poll->token])}}" class="right valign-wrapper"><i class="material-icons">edit</i></a>
        </div>
      </div>
    </div>
        <?php
      }
     ?>
    </div>
  </div>
  </main>
  @include('footer')
</body>
</html>
