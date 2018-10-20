<!doctype html>
<html>
<head>
    @include('headdata')
    <title>.:: IntElect - Benutzer ::.</title>
</head>
<body>
@include('adminnav')
<main class="container">
<div class="row valign-wrapper">
  <div class="col s10">
    <h3>Benutzer</h3>
  </div>
  <div class="col s2 valign"> <a href="{{route('admin.showUserCreate')}}" style="color: black;float: right;">
        <i class="material-icons">add_circle</i>
    </a> 
</div>
</div>
    <table class="highlight">
                                                <thead>
                                                        <th>Username</th>
                                                        <th>Rolle</th>
                                                        <th>Wahlgruppen</th>
                                                        <th>Optionen</th>
                                                </thead>
                                                <tbody>
                                                        <?php
                                                                foreach ($users as $user) {
                                                                        ?>
                                                                        <tr>
                                                                                <td>{{$user->username}}</td>
                                                                                <td><?php if($user->type==1){echo "Administrator";}else {echo "Wahlgruppenleiter";} ?></td>
                                                                                <td>{{$user->election_groups}}</td>
                                                                                <td>
                                                                                        <a href="{{route('Admin.showUsersEdit', ['id' => $user->id])}}" style="color:black;"><i class="material-icons">edit</i></a>
                                            <a href="{{route('admin.deleteUser', ['id' => $user->id])}}" style="color:black;"><i class="material-icons">delete</i></a>
                                                                                </td>
                                                                        </tr>
                                                                        <?php

                                                                }
                                                        ?>
                                                </tbody>
                                </table>
    </div>
</main>
@include('footer')
<!-- <script>
$(document).ready(function(){
var message=<?php if(isset($message)) {echo $message;} ?>;
if(message != null){
	if(message == 1){
		Materialize.toast('Zuerst Wahlgruppen von User entfernen!', 4000);
	}
}
});
</script> -->
</body>
</html>
