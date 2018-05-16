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
        <?php 
      foreach ($elections as $election) {
        foreach ($electiongroups as $electiongroup) {
            foreach($supervisedGroupsperElection as $sg){
                if($election->id==$sg->eleid && $electiongroup->id==$sg->elegroupid){
                ?>
                <div class="col s12 m4">
              <div class="card grey lighten-4 medium">
                <div class="card-content black-text">
                  <span class="card-title black-text">{{$electiongroup->name}} {{$election->name}}</span>
                  <p>{{$election->description}}</p>
                  <p>Gruppengröße: {{$electiongroup->member_count}}
                </div>
                <?php
                $checkIfTokensAlreadyExist = DB::table('token')->where('election_id', $sg->eleid)->where('election_group_id', $sg->elegroupid)->get();
                if(!$checkIfTokensAlreadyExist->isEmpty()){
                ?>
                 <div class="card-action">
                  <a href=<?php echo route('egl.showTokenList',['electionid'=>$sg->eleid, 'electiongroupid'=>$sg->elegroupid]);?>>Token PDF</a>
                </div><?php 
            	}else{
            		?><div class="container">
					  <form action=<?php echo route('egl.generateTokenlist');?> method="post" onsubmit="return validateform()">
					  	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					    <p class="range-field">
					     <input type="range" id="amount" min="0" class='tovalidate' max="{{$electiongroup->member_count}}" name="amount"/>
					       <center><output for="amount" class="output"></output></center>
					   </p>
					   <input type="hidden" name="election_id" value="{{$election->id}}"/>
					   <input type="hidden" name="election_group_id" value="{{$electiongroup->id}}"/>
					    <center><button class="btn waves-effect waves-light" type="submit" name="action">Erstelle Tokens</button></center>
					  </form>
					</div>
            		<?php
            	}
                ?>
              </div>
            </div>
        <?php
      }}}}?>
      </div>
  </div>
</body>
</html>
