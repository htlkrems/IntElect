<!doctype html>
<html>

<head>
@include('headdata')
<title>.:: IntElect - Statistik {{$poll->title}} ::.</title>
  <script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>
</head>

<body>
@include('mainnav')
<main class="container">
  <div class="row">
    <div class="col s12">
      <div class="chart-container responsive">
        <h2><?php echo $poll->title; ?></h2> 
        <p><b>Beginn der Wahl: </b>{{ date("d.m.Y H:i:s", strtotime($poll->begin)) }}</p>
        <p><b>Ende der Wahl: </b>{{ date("d.m.Y H:i:s", strtotime($poll->end)) }}</p>
        <p><b>Maximale Teilnehmerzahl: </b>{{$poll->max_participants}}</p>
        <p><b>Tatsächliche Teilnehmerzahl: </b>{{$poll->current_participants}}</p>
        <p>{{ $poll->description }}</p>
      </div>
    </div>
  </div>
  <div class="row">
  <h4>Punkteverteilung der verschiedenen Auswahlmöglichkeiten</h4>
  </div>
  <div class="row">
   <div class="col s12">
       <div class="chart-container responsive">
         <canvas id="barchart"></canvas>
      </div>
    </div>
    </div>
</main>
@include('footer')
<script>
$(document).ready(function(){
var names = [];
var points = [];
var colours = [];
var statistics = <?php echo json_encode($statistics) ?>;

var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
         };

for(var i in statistics) {
  names.push(statistics[i].otext);
  points.push(statistics[i].oaverage);
  colours.push(dynamicColors());
}

var bar_ctx = document.getElementById("barchart").getContext('2d');
var myBarChart = new Chart(bar_ctx,{
    type: 'bar',
    data: {
          labels: names,
          datasets : [{
                     label: names,
                     data: points,
                     backgroundColor: colours,
                     }]
          },
    options: {
      scales: {
              yAxes: [{
                     ticks: {
                             beginAtZero: true
                            }
                     }]
              },
      title: {
        display: true,
        text: 'Statistiken mittels Balkendiagramm'
      },
      legned: {display: true}
    }
});



});
</script>
</body>
</html>
