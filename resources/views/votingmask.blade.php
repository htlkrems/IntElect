<html>
@include('headdata')
<title>.:: IntElect - {{$election->name}} ::.</title>
      <script>
         $(document).ready(function() {
            $('select').material_select();
           $('select').on('change', function() {

            /* enable any previously disabled options */
            $('option[disabled]').prop('disabled', false);
            /* loop over each select */
            $('select option[value!="0"]:selected').parent().each(function() {

               /* for every other select, disable option which matches this this.value */
            $('select').not(this).find('option[value="' + this.value + '"]').prop('disabled', true); 

            });
            $('select').material_select();
          });

});
</script>
</head>
<body>
@include('mainnav')
  <main class="container">
    <div class="row">
      <form class="col s12" method="post" action="{{route('Vote.elect')}}" enctype="multipart/form-data" onsubmit="return validateform()">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        <input type="hidden" name="electionid" value="{{$election->id}}">
        <input type="hidden" name="electiongroupid" value="{{$election_group->id}}">
        <input type="hidden" name="token" value="{{$token->token}}">
        <table class="highlight">
          <thead>
            <th>Name</th>
            <th>Partei/Klasse</th>
            <th>Vergebe deine Stimme!</th>
          </thead>
          <tbody>
        <?php 
        foreach ($candidates as $candidate) {
          ?><tr>
            <td>{{$candidate->name}}</td>
            <td>{{$candidate->party}}</td>
            <td>
              <?php 
                echo "<select class='tovalidate' name=\"votes[$candidate->id]\">";
                ?>
                <option value="0" selected="true">0</option>
                <option value="1">1</option>
                <?php                 
                  if($election->type==2 || $election->type==3){?>
                <option value="2">2</option>
                <?php 
                } if($election->type==1) {
                ?>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		<?php
		}
		?>
              </select>
            </td>
          </tr>
          <?php
        }
        ?>
      </tbody>
      </table>
      <center><button class="btn waves-effect waves-light" type="submit" name="action">Absenden</button></center>
    </form>
  </div>
</main>
@include('footer')
</body>
</html>
