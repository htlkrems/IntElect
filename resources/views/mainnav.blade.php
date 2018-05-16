<ul id="userdropdown" class="dropdown-content">
  <?php
        if(Session::has('role')){
          if(Session::get('role')==1){ ?>
        <li><a href="{{route('admin.showStartPage')}}"><i class="material-icons left">settings</i>Admin-Bereich</a></li>
        <?php
          }
        if(Session::get('role')==0){ ?>
        <li><a href="{{route('egl.showStartPage')}}"><i class="material-icons left">people</i>Wahlgruppenleiter-Bereich</a></li>
        <?php
          }}
        ?>
  <li class="divider"></li>
  <li><a href="{{route('Home.changePassword')}}"><i class="material-icons left">build</i>Passwort ändern</a></li>
  <li class="divider"></li>
  <li><a href="{{route('Home.logout')}}"><i class="material-icons left">lock_open</i>Ausloggen</a></li>
</ul>
<nav>
    <div class="nav-wrapper cyan darken-1">
      <a href="{{route('Home.showStartPage')}}" class="brand-logo" style="padding-left:20px">IntElect</a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="{{route('Home.showRegister')}}"><i class="material-icons left">assignment_ind</i>Kandidatenregistrierung</a></li>
	<?php
	if(Session::has('role')){ ?>
	<li><a id="desktop-dropdown-button" href="#!" data-activates="userdropdown" data-constrainwidth="false" data-beloworigin="true"><i class="material-icons left">person</i>{{Session::get('username')}}<i class="material-icons right">arrow_drop_down</i></a></li>
	<?php
          } else {
            ?>
	<li><a href="{{route('Home.showLogin')}}"><i class="material-icons left">lock</i>Anmelden</a></li>
	<?php
          }
        ?>
	</ul>
        <ul class="side-nav" id="mobile-demo">
            <li><a href="{{route('Home.showRegister')}}"><i class="material-icons left">assignment_ind</i>Kandidatenregistrierung</a></li>
            <?php
        if(Session::has('role')){ ?>
	  <li class="divider"></li>
	  <li><a href="#!"><i class="material-icons left">person</i>{{Session::get('username')}}<i class="material-icons right">arrow_drop_down</i></a></li>
	<?php  if(Session::get('role')==1){ ?>
        <li><a href="{{route('admin.showStartPage')}}"><i class="material-icons left">settings</i>Admin-Bereich</a></li>
        <?php
          }
        if(Session::get('role')==0){ ?>
        <li><a href="{{route('egl.showStartPage')}}"><i class="material-icons left">people</i>Wahlgruppenleiter-Bereich</a></li>
        <?php
          }
        ?>
	<li><a href="{{route('Home.changePassword')}}"><i class="material-icons left">build</i>Passwort ändern</a></li>
        <li><a href="{{route('Home.logout')}}"><i class="material-icons left">lock_open</i>Ausloggen</a></li>
        <?php
          } else {
            ?> 
        <li><a href="{{route('Home.showLogin')}}"><i class="material-icons left">lock</i>Anmelden</a></li>
        <?php 
          }  
        ?>
      </ul>
    </div>
</nav>
<script>
$( document ).ready(function(){
    $(".button-collapse").sideNav();
    $("#desktop-dropdown-button").dropdown();
});
</script>
