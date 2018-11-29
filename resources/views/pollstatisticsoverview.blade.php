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
      	<div class="col s12">
     <h4>Umfragen</h4><br>
     <?php 
      foreach ($polls as $poll) {
        ?>

        <div class="col s12 m4">
      <div class="card grey lighten-4 small">
        <div class="card-content black-text">
          <span class="card-title black-text">{{$poll->title}}</span>
          <p>{{$poll->description}}</p>
        </div>
         <div class="card-action">
          <a href="{{route('Poll.showPollStatistics',['poll_id'=>$poll->token])}}">Weitere Informationen</a>
          <a href="{{route('Poll.deletePoll',['poll_id'=>$poll->token])}}">Löschen</a>
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