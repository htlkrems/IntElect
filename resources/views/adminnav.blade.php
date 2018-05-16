<ul id="userdropdown" class="dropdown-content">
  <li><a href="{{route('Home.changePassword')}}"><i class="material-icons left">build</i>Passwort ändern</a></li>
  <li class="divider"></li>
  <li><a href="{{route('Home.logout')}}"><i class="material-icons left">lock_open</i>Ausloggen</a></li>
</ul>
<nav>
    <div class="nav-wrapper cyan darken-1">
      <a href="{{route('Home.showStartPage')}}" class="brand-logo" style="padding-left:20px">IntElect</a>
      <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
      <ul class="right hide-on-med-and-down">
        <li><a href="{{route('admin.showUsers')}}"><i class="material-icons left">people_outline</i>Users</a></li>
        <li><a href="{{route('admin.showElectionGroups')}}"><i class="material-icons left">people</i>Wahlgruppen</a></li>
        <li><a href="{{route('admin.showElectionOverview')}}"><i class="material-icons left">assignment</i>Wahlen</a></li>
	<li><a id="desktop-dropdown-button" href="#!" data-activates="userdropdown" data-constrainwidth="false" data-beloworigin="true"><i class="material-icons left">person</i>{{Session::get('username')}}<i class="material-icons right">arrow_drop_down</i></a></li>
	</ul>
        <ul class="side-nav" id="mobile-demo">
        <li><a href="{{route('admin.showUsers')}}"><i class="material-icons left">people_outline</i>Users</a></li>
        <li><a href="{{route('admin.showElectionGroups')}}"><i class="material-icons left">people</i>Wahlgruppen</a></li>
        <li><a href="{{route('admin.showElectionOverview')}}"><i class="material-icons left">assignment</i>Wahlen</a></li>
	<li class="divider"></li>
        <li><a href="#!"><i class="material-icons left">person</i>{{Session::get('username')}}<i class="material-icons right">arrow_drop_down</i></a></li>
	<li><a href="{{route('Home.changePassword')}}"><i class="material-icons left">build</i>Passwort ändern</a></li>
        <li><a href="{{route('Home.logout')}}"><i class="material-icons left">lock_open</i>Ausloggen</a></li>
      </ul>
    </div>
</nav>
<script>
$( document ).ready(function(){
    $(".button-collapse").sideNav();
    $("#desktop-dropdown-button").dropdown();
});
</script>
