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
          <h4>Umfrage erstellen</h4>
          <div class="divider"></div>
          <form class="col s12" method="post" action="{{route('Poll.createPoll')}}" enctype="multipart/form-data" onsubmit="return validateform()">
  		    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
              <div class="row">
                  <div class="col s12 m12 l6">
                      <div class="row">
                          <div class="input-field  col s12">
                              <input type="text" class="validate tovalidate" name="polltitle" required="" id="v_id">
                              <label for="v_id">Thema</label>
                          </div>
                          <div class="col s12">
                              <div class="input-field ">
                                  <textarea id="description" class="materialize-textarea tovalidate" name="polldescription" required></textarea><label for="description">Beschreibung</label>
                              </div>
                          </div>
                          <div class="col s12">
                  					<h5 class="col s1">Von</h5> <input placeholder="Datum" type="text" class="datepicker col s5 tovalidate" style="font-size: 20px" name="pollbegin" required> <h5 class="col s1">um</h5> <input placeholder="Uhrzeit" type="text" class="timepicker col s5" name="pollbegintime" style="font-size: 20px" required>
                  				</div>
                  				<div class="col s12">
                  					<h5 class="col s1">bis </h5> <input placeholder="Datum" type="text" class="datepicker col s5 tovalidate" name="pollend" style="font-size: 20px" required> <h5 class="col s1">um</h5> <input placeholder="Uhrzeit" type="text" class="timepicker col s5" name="pollendtime" style="font-size: 20px" required>
                  				</div>
                          <h5>Maximale Teilnehmerzahl</h5>
                          <p class="range-field col s12">
                 <input type="range" id="maxp" min="0" class='tovalidate' max="100" name="max_participants"/>
                 <center><output for="maxp" class="output"></output></center>
             </p>
                      </div>
                  </div>
                  <div class="col s12 m12 l6">
                      <div class="row">
                          <div class="input-field  col s12">
                              <input type="text" class="validate tovalidate col s11" name="optioninput" id="addToList">
                              <label for="addToList">Auswahlmöglichkeit</label>
                              <i class="material-icons col s1" name="addIcon" id="addElement" onclick="addElement()">add</i>
                              <ul class="collection col s11" id="optionlist">

                              </ul>
                              <input type="hidden" name="options" id="opt_id"/>
                          </div>
                      </div>
                  </div>
              </div>
      </div>
      <button class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
  </div>
  <div id="hello"></div>
  <script>
  $( document ).ready(function() {
     $('.timepicker').pickatime({'twelvehour': false});
     $('.datepicker').pickadate({
      monthsFull: ['Januar', 'Feber', 'März', 'April', 'Mai', 'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
      weekdaysShort: ['Mon', 'Die', 'Mit', 'Don', 'Fre', 'Sam', 'Son'],
      selectMonths: true,
      selectYears: 15,
      today: 'Today',
      clear: 'Clear',
      close: 'Ok',
      closeOnSelect: false,
      format: 'yyyy-mm-dd'
    });
  });
  function addElement(){
    var elementvalue=document.getElementById('addToList').value;
    if(elementvalue!=""){
    var ul = document.getElementById("optionlist");
    var li=document.createElement("li");
    li.appendChild(document.createTextNode(elementvalue));
    ul.appendChild(li);    
    li.onclick=function(){removeElement(this);};
    document.getElementById('addToList').value="";

    var lielements = ul.childNodes;
    var counter=0;
    var optionelement={};
    Array.prototype.forEach.call(lielements,function(child){
      optionelement[counter]=child.innerHTML;
      counter=counter+1;
    });
    document.getElementById('opt_id').value=JSON.stringify(optionelement);
  }
  }

  function removeElement(element){
    element.parentNode.removeChild(element);
var ul = document.getElementById("optionlist");
    var lielements = ul.childNodes;
    var counter=0;
    var optionelement={};
    Array.prototype.forEach.call(lielements,function(child){
      optionelement[counter]=child.innerHTML;
      counter=counter+1;
    });
    document.getElementById('opt_id').value=JSON.stringify(optionelement);
  }

  </script>
</body>
</html>
