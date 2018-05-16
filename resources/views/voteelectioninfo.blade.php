<!doctype html>
<html>

<head>
  <title>.:: IntElect - {{$election->name}} ::.</title>
  @include('headdata')
</head>

<body>
@include('mainnav')
<div class="container">
  <div class="row">
    <div class="col s12">
        <h4>{{$election->name}}</h4><br> 
        <p><b>Beginn der Kandidatenregistrierung: </b>{{ $election->candidate_registration_begin }}</p>
        <p><b>Ende der Kandidatenregistrierung: </b>{{ $election->candidate_registragion_end }}</p>
        <p><b>Beginn der Wahl: </b>{{ $election->election_begin }}</p>
        <p><b>Ende der Wahl: </b>{{ $election->election_end }}</p>
        <p><b>Beschreibung: </b>{{ $election->description }}</p>
        <?php
          if($election->type==1){
            ?>
              <p><b>Punktwahl:</b> Man kann verschiedenen Kandidaten unterschiedliche viele Punkte geben.</p>
            <?php
          } else {
              ?>
              <p><b>Kreuzsystem: </b>Nur eine Person kann gewählt werden!</p>
              <?php
          }

        ?>
    </div>
    <div class="col s12">
     <h4>Aufgestellte Kandidaten</h4><br>
     <?php 
      foreach ($candidates as $candidate) {
        ?>

        <div class="col s12 m4">
      <div class="card grey lighten-4 small">
         <?php 
          if(!is_null($candidate->picture)){
            ?>
            <div class="card-image">
              <img src="{{ url('/') }}/{{$candidate->picture}}">
            </div>
            <?php
          }
        ?>
        <div class="card-content black-text">
          <span class="card-title deep-orange-text">{{$candidate->name}} {{$candidate->party}}</span>
          <p>{{$candidate->description}}</p>
        </div>
      </div>
    </div>
        <?php
      }
     ?>
    </div>
  </div>
  <center>
    <a class="waves-effect waves-light btn" href=<?php echo route('Vote.showVotingMask',['electionid'=>$election->id]);?>>Zum Wahlvorgang</a>
  </center>
</div>
</body>
</html>
