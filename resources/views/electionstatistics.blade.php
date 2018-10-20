<!doctype html>
<html>

<head>
@include('headdata')
<title>.:: IntElect - Statistik {{$election->name}} ::.</title>
  <script type="text/javascript" src="{{ asset('js/Chart.min.js') }}"></script>
</head>

<body>
@include('mainnav')
<div class="container">
  <div class="row">
    <div class="col s12">
      <div class="chart-container responsive">
        <h2><?php echo $election->name; ?></h2> 
        <p><b>Beginn der Wahl: </b>{{ date("d.m.Y H:i:s", strtotime($election->election_begin)) }}</p>
        <p><b>Ende der Wahl: </b>{{ date("d.m.Y H:i:s", strtotime($election->election_end)) }}</p>
        <p>{{ $election->description }}</p>
      </div>
    </div>
  </div>
  <div class="row">
  <h4>Summe aller Punkte pro Kandidat:</h4>
  </div>
  <div class="row">
    <div class="col l6 m12 s12">
        <canvas id="piechart"></canvas>
   </div>
   <div class="col l6 m12 s12">
       <div class="chart-container responsive">
         <canvas id="barchart"></canvas>
      </div>
    </div>
    </div>
      <div class="row">
  <h4>Anzahl der vergebenen 1er Punkte pro Kandidat:</h4>
  </div>
    <div class="row">
    <div class="col l6 m12 s12">
        <canvas id="piechart1"></canvas>
   </div>
   <div class="col l6 m12 s12">
       <div class="chart-container responsive">
         <canvas id="barchart1"></canvas>
      </div>
    </div>
    </div>
          <div class="row">
  <h4>Anzahl der vergebenen 2er Punkte pro Kandidat:</h4>
  </div>
    <div class="row">
    <div class="col l6 m12 s12">
        <canvas id="piechart2"></canvas>
   </div>
   <div class="col l6 m12 s12">
       <div class="chart-container responsive">
         <canvas id="barchart2"></canvas>
      </div>
    </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
var names = [];
var points = [];
var colours = [];
var statistics = <?php echo json_encode($statistics) ?>;

var names1 = [];
var points1 = [];
var colours1 = [];
var statistics1 = <?php echo json_encode($statistics1) ?>;

var names2 = [];
var points2 = [];
var colours2 = [];
var statistics2 = <?php echo json_encode($statistics2) ?>;

var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
         };

for(var i in statistics) {
  names.push(statistics[i].name);
  points.push(statistics[i].points);
  colours.push(dynamicColors());
}

var pie_ctx = document.getElementById("piechart").getContext('2d');
var myPieChart = new Chart(pie_ctx,{
    type: 'pie',
    data: {
          labels: names,
          datasets : [{
                     label: "Stimmen",
                     data: points,
                     backgroundColor: colours
                     }]
          },
    options: {
      title: {
        display: true,
        text: 'Statistiken mittels Kreisdiagramm'
      },
      legend: { display: true }
    }
});

//var myPieChart=new Chart(pie_ctx).Pie(parseInt(<?php echo json_encode($statistics) ?>));

var bar_ctx = document.getElementById("barchart").getContext('2d');
var myBarChart = new Chart(bar_ctx,{
    type: 'bar',
    data: {
          labels: names,
          datasets : [{
                     label: "Stimmen",
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

for(var i in statistics1) {
  names1.push(statistics1[i].name);
  points1.push(statistics1[i].points);
  colours1.push(dynamicColors());
}

var pie_ctx = document.getElementById("piechart1").getContext('2d');
var myPieChart = new Chart(pie_ctx,{
    type: 'pie',
    data: {
          labels: names1,
          datasets : [{
                     label: "Stimmen",
                     data: points1,
                     backgroundColor: colours1
                     }]
          },
    options: {
      title: {
        display: true,
        text: 'Statistiken mittels Kreisdiagramm'
      },
      legend: { display: true }
    }
});

//var myPieChart=new Chart(pie_ctx).Pie(parseInt(<?php echo json_encode($statistics) ?>));

var bar_ctx = document.getElementById("barchart1").getContext('2d');
var myBarChart = new Chart(bar_ctx,{
    type: 'bar',
    data: {
          labels: names1,
          datasets : [{
                     label: "Stimmen",
                     data: points1,
                     backgroundColor: colours1,
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

for(var i in statistics2) {
  names2.push(statistics2[i].name);
  points2.push(statistics2[i].points);
  colours2.push(dynamicColors());
}

var pie_ctx = document.getElementById("piechart2").getContext('2d');
var myPieChart = new Chart(pie_ctx,{
    type: 'pie',
    data: {
          labels: names2,
          datasets : [{
                     label: "Stimmen",
                     data: points2,
                     backgroundColor: colours2
                     }]
          },
    options: {
      title: {
        display: true,
        text: 'Statistiken mittels Kreisdiagramm'
      },
      legend: { display: true }
    }
});

//var myPieChart=new Chart(pie_ctx).Pie(parseInt(<?php echo json_encode($statistics) ?>));

var bar_ctx = document.getElementById("barchart2").getContext('2d');
var myBarChart = new Chart(bar_ctx,{
    type: 'bar',
    data: {
          labels: names2,
          datasets : [{
                     label: "Stimmen",
                     data: points2,
                     backgroundColor: colours2,
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
