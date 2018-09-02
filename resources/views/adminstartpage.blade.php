 <!doctype html>
    <html>
        <head>
            @include('headdata')
	    <title>.:: IntElect - Admin ::.</title>
            <style type="text/css">
                p{
                    overflow: break-word;
                }
            </style>
        </head>
        <body>
            @include('adminnav')
            <div class="container">
                <div class="row">
                    <div class="col s12">
                        <div class="row">
                            <h3 class="col s11">Wahlen</h3>
                            <h3 class="col s1">
                                <a href=<?php echo route('admin.showElectionCreate');?> style="color: black;">
                                    <i class="small material-icons">add_circle</i>
                                </a>
                            </h3>
                        </div>
                        <div class="row">
                        <?php
                            foreach ($runningelections as $runningelection) {
                                ?>
                                    <div class="col l6 m6 s12" style="border: 1px solid #cccccc;"><div class="container">
                                        <div class="row">
                                            <h4 class="col s11" style="overflow:break-word">#{{$runningelection->id}} {{$runningelection->name}}</h4>
                                            <h4 class="col s1">
                                                <a href=<?php echo route('admin.showElectionEdit',['e_id'=>$runningelection->id]);?> style="color: black;">
                                                    <i class="small material-icons">edit</i>
                                                </a>
                                            </h4>
                                        </div>
                                        <div class="row">
                                        <ul class="collection col s12">
                                            <?php 
                                                foreach ($verifiedcandidates as $verifiedcandidate) {
                                                    if($verifiedcandidate->election_id==$runningelection->id){
                                                    ?>
                                                        <li class="collection-item">{{$verifiedcandidate->name}}</li>
                                                    <?php
                                                    }
                                                }
                                            ?>
                                        </ul></div></div>
                                    </div>
                                <?php
                            }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col s12 m6">
                            <h4>Neue Kandidaten</h4>
                            <ul class="collection col s12">
                            <?php
                                foreach ($unverifiedcandidates as $ucandidate) {
                                    ?>
                                    <li class="collection-item">
                                            {{$ucandidate->cname}}, {{$ucandidate->cparty}} - {{$ucandidate->ename}}
                                            <a href=<?php echo route('admin.verifyUser',['id'=>$ucandidate->cid]);?> style="color: black;float: right;">
                                                <i class="small material-icons">check</i>
                                            </a>
                                             <a href=<?php echo route('admin.denyCandidate',['id'=>$ucandidate->cid]);?> style="color: black;float: right;">
                                                <i class="small material-icons">clear</i>
                                            </a>
                                    </li>
                                    <?php
                                }
                            ?>
                        </ul>
                        </div>
                        <div class="col s12 m6">
                            <h4>Abgeschlossene Wahlen</h4>
                             <ul class="collection col s12">
                            <?php
                                foreach ($closedelections as $ce) {
                                    ?>
                                    <li class="collection-item">
                                            #{{$ce->id}} {{$ce->name}}
                                            <a href=<?php echo route('Statistics.showChart', ['election_id'=>$ce->id]);?> style="color: black; float: right;">
                                                <i class="small material-icons">assessment</i>
                                            </a>
                                             <a href=<?php echo route('Statistics.generateReport', ['election_id'=>$ce->id]);?> style="color: black;float: right;">
                                                <i class="small material-icons">share</i>
                                            </a>
                                    </li>
                                    <?php
                                }
                            ?>
                        </ul>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </body>
    </html>
