<?php
// set namespace
namespace App\Http\Controllers;
use View;
use Illuminate\Http\Request;
use App\Candidate;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use PDF;
use DB;
use Session;
//include method for input validation
include(app_path().'/includes/validation.php');
/*
  The HomeController is responsible for the startpage of the application and general functionality.
  This class shows several different pages, enables visitors to register for an election, provides the login and changePassword functionality. 
*/
class HomeController extends Controller{
  //Shows the StartPage
  public function showStartPage(Request $request) {
      return view('startpage', ['message' => $request->message]);
  }
  //Shows the Login Page
  public function showLogin(Request $request){
    //Check if user is already logged in and redirects user
	if (Session::has('role')) {
            if (Session::get('role') == 1) {
	    	return redirect(route('admin.showStartPage'));
	    }
	    if (Session::get('role') == 0) {
                return redirect(route('egl.showStartPage'));
            }
	}
      return view('login', ['message' => $request->message]);
  }
  //Shows the Register page.
  public function showRegister(Request $request) {
      $runningelections=DB::table('election')->where('election_end','>=',date('Y-m-d H:i:s'))
                                         ->orWhereNull('election_end')->get();
        return view('registerpage', ['elections'=>$runningelections, 'message' => $request->message]);
  }
  //Writes the Registration information into the database
  public function Register(Request $request) {
	    if(!validateInputs([ $request->firstName, $request->lastName, $request->partyinput, $request->DescriptionInput, $request->electionselect ])) { return redirect(route('Home.showRegister', ['message' => 1])); }
	    $newCandidate = new Candidate();

	    if($request->file('file')!==null){
		    $file = $request->file('file');
		    $name= time().$file->getClientOriginalName();
		    $file->move('uploads/',$name);
		    $newCandidate->picture="uploads/".$name;
	    }
	    $newCandidate->name= $request->firstName." ".$request->lastName;
	    $newCandidate->party=$request->partyinput;
	    $newCandidate->description=$request->DescriptionInput;
	    $newCandidate->election_id=$request->electionselect;
	    $newCandidate->verified=0;

	    $newCandidate->save();
      return redirect(route('Home.showStartPage', ['message'=> 54]));
  }
  //Login-Functionality
  public function login(Request $request) {
	if(!validateInputs([ $request->username ])) { return redirect(route('Home.showLogin', ['message' => 1])); }
        // create our user data for the authentication
        $userdata = array(
        'username'     => $request->username, // Input::get('username'),
        'password'  => $request->password  // Input::get('password')
         );
         // attempt to do the login
         if (Auth::guard('web')->attempt($userdata)) {
              // validation successful!
              // redirect them to the secure section or whatever
              // return Redirect::to('secure');
              $role = DB::table('user')->where('username', $request->username)->value('type');
              // $role = DB::select('SELECT type FROM user WHERE username = :username', ['username' => Input::get('username')]);
              
              $request->session()->put('username', $request->username);
              $request->session()->put('role', $role);
              if ($role == 1) { // admin
                  return redirect(route('admin.showStartPage', ['message'=>51])); // change with adminstartpage
              } else { // egl
                  return redirect(route('egl.showStartPage', ['message'=>51])); //change with egl startpage
              }
         } else {        
              // validation not successful, send back to form 
              // return Redirect::to('login');
              return redirect(route('Home.showLogin', ['message' => 2]));
         }
    }
    //Logout-Functionality
    public function logout(Request $request)
    {
    	Session::flush();
    	return redirect(route('Home.showStartPage', ['message' => 52]));
    }
    //Changes the password in the database
    public function changePassword(Request $request){
      $usercheck = User::find($request->userid);
      if (!is_null($request->session()->get('role'))) {
        if(!is_null($request->session()->get('username'))){
          if($request->session()->get('role')==$usercheck->type){ 
            if($request->session()->get('username')==$usercheck->username){ 
              $userdata = array(
              'username'     => $request->username, // Input::get('username'),
              'password'  => $request->password  // Input::get('password')
              );    
              if (Auth::guard('web')->attempt($userdata)) {
                if($request->newpassword==$request->newpasswordconfirm){
                  $usercheck->password = password_hash($request->newpassword, PASSWORD_BCRYPT);
                  $usercheck->save();
		  if (Session::get('role') == 1) { // admin
                  return redirect(route('admin.showStartPage', ['message'=>55])); // change with adminstartpage
             	  } else { // egl
                  return redirect(route('egl.showStartPage', ['message'=>55])); //change with egl startpage
             	 }
                } else { return redirect(route('Home.showChangePassword', ['message'=>7])); }
              } else { return redirect(route('Home.showChangePassword', ['message'=>8])); }
            }
          }
        }
      }
      return redirect(route('Home.showLogin', ['message'=>3]));
    }
    //Shows the ChangePassword-Page
    public function showChangePassword(Request $request){
      if (Session::has('role')&&Session::has('username')) {
        $user = DB::table('user')->where('username', '=', Session::get('username'))->first();
        return view('changeUserPassword',['user'=>$user, 'message'=>$request->message]);
      }
        return redirect(route('Home.showLogin', ['message'=>3]));
    }
}
