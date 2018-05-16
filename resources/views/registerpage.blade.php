<html>
<head>
	@include('headdata')
	<title>.:: IntElect - Kandidatenregistrierung ::.</title>
      <script>
         $(document).ready(function() {
            $('select').material_select();
         });
      </script>
</head>
<body>
   @include('mainnav')
<div class="container">
    <div class="row">
        <h4>Als Kandidat registrieren</h4>
        <div class="divider"></div>
        <form class="col s12" method="post" action="{{URL::to('registerasCandidate')}}" enctype="multipart/form-data" onsubmit="return validateform()">
		    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
            <div class="row">
                <div class="col s12 m12 l6">
                    <div class="row">
                        <div class="input-field  col s12">
                            <input type="text" class="validate tovalidate" name="firstName" required="" id="v_id">
                            <label for="v_id">Vorname</label>
                        </div>
                        <div class="input-field col s12">
                            <input id="nachname" type="text" class="validate tovalidate" name="lastName" id="n_id" required="">
                            <label for="n_id">Nachname</label>
                        </div>
                        <div class="col s12">
                            <div class="input-field ">
                                <textarea id="description" class="materialize-textarea tovalidate" name="DescriptionInput" placeholder="Beschreibung" required></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m12 l6">
                    <div class="row">
                        <div class="file-field input-field col s12">
                            <div class="btn col s12 m6">
                                <span>Bild</span>
                                <input type="file" name="file" id="file">
                            </div>
                            <div class="file-path-wrapper s12 m6">
                                <input class="file-path validate" type="text" name="FileInput" placeholder="Bild hochladen">
                            </div>
                        </div>
                        <div class="input-field  col s12">
                            <input type="text" class="validate tovalidate" name="partyinput" placeholder="Klasse/Partei">
                        </div>
                        <div class="input-field col s12">
                            <select name="electionselect" required="" id="selectDropdown">
                                <?php
                                foreach($elections as $election){
                                    echo "<option value=\"".$election->id."\">".$election->name."</option>";
                                }
                                ?>
                            </select>
                        </div>


                    </div>
                </div>
            </div>
    </div>
    <button class="btn waves-effect waves-light" type="submit" name="action">Submit</button>
</div>
</div>
</form>
</div>
</div>
</body>
</html>
