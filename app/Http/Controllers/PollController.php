<?php

// set namespace
namespace App\Http\Controllers;
use View;
use Illuminate\Http\Request;
use App\Candidate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use PDF;
use DB;
use Session;
use App\User;
use App\Poll;
use App\Option;

// include function for input validation
include(app_path().'/includes/validation.php');

class PollController extends Controller
{
    public function showCreatePollView(Request $request)
    {
        //check if Election Group Leader is logged in
        if(Session::has('role')){
            if(Session::get('role')==0){
		return view('createpollview', ['message' => $request->message]);
	    }
	}
    }

    public function showUpdatePollView(Request $request)
    {
        //check if Election Group Leader is logged in
        if(Session::has('role')){
            if(Session::get('role')==0){
		$poll = DB::table('poll')->where('id', $request->poll_id)->first();
		$options = DB::table('option')->where('poll_id', $request->poll_id)->get();
                return view('updatepollview', ['poll' => $poll, 'options' => $options, 'message' => $request->message]);
            }
        }
    }

    public function createPoll(Request $request){
	if(Session::has('role')){
            if(Session::get('role')==0){
        try {
	    DB::beginTransaction();

	    $newPoll = new Poll();
	    $newPoll->title=$request->polltitle;
	    $newPoll->description=$request->polldescription;
	    while(true){
		    $token=$this->generateRandomString();
                    $tokenInDb = DB::table('poll')
                        ->where('token', '=', $token)
                        ->first();
		    if(is_null($tokenInDb)){
			break;
		    }
	    }
	    $newPoll->token=$token;
	    $newPoll->begin=$request->pollbegin;
	    $newPoll->end=$request->pollend;
	    $newPoll->max_participants=$request->pollmaxparticipants;
	    $newPoll->user_id=DB::table('user')->where('username',Session::get('username'))->value('id');
	    $newPoll->save();

	    foreach ($request->options as $option){
		DB::table('option')->insert(array('text' => $option->text, 'poll_token' => $token) );
	    }

	    DB::commit();
	    return redirect(route('showpolloverview', ['message'=>0]));
        } catch (Exception $e) {
                DB::rollBack();
		return parent::report($e);
        }
	}}
    }

    public function deletePoll(Request $request){
	if(Session::has('role')){
            if(Session::get('role')==0){
		DB::table('poll')->where('token', $request->token)->delete();
		return redirect(route('showpolloverview', ['message'=>0]));
	    }
	}
    }

    public function updatePoll(Request $request){
        if(Session::has('role')){
            if(Session::get('role')==0){
		try {
	            DB::beginTransaction();

		    DB::table('option')->where('poll_token', $request->polltoken)->delete();
		    $poll = Poll::findOrFail($request->polltoken);
		    $poll->title=$request->polltitle;
	            $poll->description=$request->polldescription;
		    $poll->begin=$request->pollbegin;
	            $poll->end=$request->pollend;
        	    $poll->max_participants=$request->pollmaxparticipants;

		    foreach ($request->options as $option){
	                DB::table('option')->insert(array('text' => $option->text, 'poll_token' => $token) );
        	    }

		    DB::commit();
                    return redirect(route('showpolloverview', ['message'=>0]));

		    } catch (Exception $e) {
         	       DB::rollBack();
                	return parent::report($e);
       		    }
            }
        }
    }

    //Generates the token string
    private function generateRandomString($length = 6) {
        //In order to avoid confusion, only certain characters are used for the token generation
        $characters = '23456789ABCDEGHJKLMNPRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function showJoinPollView(Request $request)
    {
        //check if Election Group Leader is logged in
        if(Session::has('role')){
            if(Session::get('role')==0){
                return view('joinpollview', [ 'poll' => Poll::findOrFail($request->polltoken), 'message' => $request->message]);
            }
        }
    }

    public function showAssessView(Request $request)
    {
	//TODO
	$poll = Poll::findOrFail($request->polltoken);
	if(is_null($poll->begin)){
	    return view('waitingview', [ 'poll' => Poll::findOrFail($request->polltoken), 'message' => $request->message]);
	} else {
	    if($poll->begin < date('Y-m-d H:i:s') && $poll->end > date('Y-m-d H:i:s')) {
        	return view('assessview', [ 'poll' => Poll::findOrFail($request->polltoken), 'message' => $request->message]);
	    }
	}
    }

    public function inputPollTokenView(Request $request)
    {
        return view('inputpolltokenview', [ 'message' => $request->message]);
    }

#    public function showJoinPollView(Request $request)
#    {
#        //check if Election Group Leader is logged in
#        if(Session::has('role')){
#            if(Session::get('role')==0){
#                return view('joinpollview', [ 'poll' => Poll::findOrFail($request->polltoken), 'message' => $request->message]);
#            }
#        }
#    }
}
