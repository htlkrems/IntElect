<!doctype html>
<html>

<head>
   @include('headdata')
   <title>.:: IntElect - Startseite ::.</title>
</head>

<body>
    @include('mainnav')
<div class="container">
  <div class="row">
    <div class="col s12 m4">
      <div class="card teal darken-1 small">
        <div class="card-content white-text">
          <span class="card-title">Vergangene Wahlen</span>
          <p>Die Ergebnisse bereits vergangener Wahlen werden mithilfe von Diagrammen dargestellt. Es werden sowohl Kreisdiagramme als auch Balkendiagramme verwendet.</p>
        </div>
        <div class="card-action">
          <a href="statistics/showClosedElections">Vergangene Wahlen einsehen</a>
        </div>
      </div>
      </div>
      <div class="col s12 m4">
      <div class="card blue-grey darken-2 small">
        <div class="card-content white-text">
          <span class="card-title">Wählen</span>
          <p>Mithilfe eines Einmal-Codes, welchen Sie von ihrem Wahlgruppenleiter/Lehrer erhalten haben sollen, können Sie bei einer bestimmten Wahl mitentscheiden, wer gewinnen soll.</p>
        </div>
        <div class="card-action">
          <a href="{{route('Vote.showTokenMask')}}">Zum Wahlvorgang</a>
        </div>
      </div>
    </div>
     <div class="col s12 m4">
      <div class="card teal darken-1 small">
        <div class="card-content white-text">
          <span class="card-title">Aktuelle Wahlen</span>
          <p>Aufgrund der Tatsache, dass bestimmte Wahlen noch nicht abgeschlossen wurden, können nur generelle Informationen zu diesen Wahlen bekannt gegeben werden. </p>
        </div>
        <div class="card-action">
          <a href="statistics/showRunningElections">Aktuelle Wahlen einsehen</a>
        </div>
      </div>
    </div>
    </div>
  </div>
</div>
</body>
</html>
