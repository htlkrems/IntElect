 <html>
<head>
@include('headdata')
<title>.:: IntElect - Wahlen ::.</title>
</head>
<body>
@include('adminnav')
<main class="container">
  <div class="row">
      <div class="col l12 m12 s12">
        <div class="row valign-wrapper"><div class="col s10"><h3>Aktuelle Wahlen </h3></div>
    <div class="col s2 valign">
        <a href="{{route('admin.showElectionCreate')}}" class="black-text" style="float: right;"><i class="small material-icons">add_circle</i></a>
    </div></div>
        <?php
        foreach ($elections as $election) {
          if($election->election_end!=null && $election->election_end < date('Y-m-d H:i:s')){
            continue;
          }
          ?>
          <div class="card grey lighten-4">
            <div class="card-content">
                <div class="card-title row valign-wrapper">
          <div class="col s6 m9" style="overflow: hidden; text-overflow: ellipsis;">{{$election->name}}</div>
          <div class="col s2 m1 valign"> 
            <a href="{{route('admin.showElectionEdit', ['id' => $election->id])}}" class="black-text"><i class="small material-icons">edit</i></a> 
          </div>
          <div class="col s2 m1 valign"> 
            <a href="{{route('admin.closeElection', ['eId' => $election->id])}}" class="black-text"><i class="small material-icons">assignment_turned_in</i></a> 
          </div>
          <div class="col s2 m1 valign">
            <a href="{{route('admin.deleteElection', ['e_id'=>$election->id])}}" class="black-text"><i class="small material-icons">delete</i></a>
          </div>
            </div>
        <p class="valign-wrapper">
     <i class="material-icons">info</i> {{$election->candidates}} Kandidaten, {{$election->election_groups}} Wahlgruppen, {{$election->member_count}} Wahlberechtigte
              </p>
              <p class="valign-wrapper">
                 <i class="material-icons">access_time</i> {{$election->election_begin}} bis {{$election->election_end}}
              </p>
    </div>
          <?php
            }
          ?>
    
  </div>
  </div>
  <div class="col l12 m12 s12">
        <div class="row valign-wrapper"><div class="col s12"><h3>Abgeschlossene Wahlen</h3></div></div>
        <?php
        foreach ($elections as $election) {
          if($election->election_end!=null && $election->election_end > date('Y-m-d H:i:s')){
            continue;
          }
          ?>

    <div class="card grey lighten-4">
            <div class="card-content vl">
              <div class="card-title row">
                <div class="col s6 m9" style="overflow: hidden; text-overflow: ellipsis;">{{$election->name}}</div>
                <div class="col s2 m1"> <a href="{{route('Statistics.showChart', ['election_id'=>$election->id])}}" class="black-text"><i class="small material-icons">assessment</i></a> </div>
                <div class="col s2 m1"> <a href="{{route('Statistics.generateReport', ['election_id'=>$election->id])}}" class="black-text"><i class="small material-icons">share</i></a> </div>
    <div class="col s2 m1"> <a href="{{route('admin.deleteElection', ['e_id'=>$election->id])}}" class="black-text"><i class="small material-icons">delete</i></a> </div>
              </div>
              <p class="valign-wrapper">   
                 <i class="material-icons">info</i> {{$election->candidates}} Kandidaten, {{$election->election_groups}} Wahlgruppen, {{$election->member_count}} Wahlberechtigte
              </p>
              <p class="valign-wrapper"> 
                 <i class="material-icons">access_time</i> {{$election->election_begin}} bis {{$election->election_end}}
              </p>
          </div>
            </div>
          <?php
            }
          ?>
    
  </div>
</main>
@include('footer')
</body>
</html>
