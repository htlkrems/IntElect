<html>
<head>
@include('headdata')
<title>.:: IntElect - Vergangene Wahlen ::.</title>
</head>
<body>
@include('mainnav')
  <div class="container">
    <div class="row">
    <div class="col s12">
     <h4>Vergangene Wahlen</h4><br>
     <?php 
      foreach ($elections as $election) {
        ?>

        <div class="col s12 m4">
      <div class="card grey lighten-4 small">
        <div class="card-content black-text">
          <span class="card-title black-text">{{$election->name}}</span>
          <p>{{$election->description}}</p>
        </div>
         <div class="card-action">
          <a href=<?php echo route('Statistics.showChart',['election_id'=>$election->id]);?>>Weitere Informationen</a>
        </div>
      </div>
    </div>
        <?php
      }
     ?>
    </div>
  </div>
  </div>
</body>
</html>
