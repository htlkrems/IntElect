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
        $poll = DB::table('poll')->where('token', $request->poll_id)->first();
        $options = DB::table('option')->where('poll_token', $request->poll_id)->get();
                return view('updatepoll', ['poll' => $poll, 'options' => $options, 'message' => $request->message]);
            }
        }
	return redirect(route('Home.showLogin', ['message' => 3]));
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
        $newPoll->begin=$request->pollbegin.' '.$request->pollbegintime;
        $newPoll->end=$request->pollend.' '.$request->pollendtime;
        $newPoll->max_participants=$request->max_participants;
        $newPoll->user_id=DB::table('user')->where('username',Session::get('username'))->value('id');
        $newPoll->save();
        foreach (json_decode($request->options) as $option){
        DB::table('option')->insert(array('text' => $option, 'poll_token' => $token) );
        }

        DB::commit();
        return redirect(route('Poll.showPollOverview', ['message'=>57]));
        } catch (Exception $e) {
                DB::rollBack();
        return parent::report($e);
        }
    }}
	return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function deletePoll(Request $request){
	if(Session::has('role')){
            if(Session::get('role')==0){
        DB::table('poll')->where('token', $request->poll_id)->delete();
        return redirect(route('Poll.showPollOverview', ['message'=>63]));

        }
    }
	return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function updatePoll(Request $request){
       if(Session::has('role')){
            if(Session::get('role')==0){
        try {
                DB::beginTransaction();

            //DB::table('option')->where('poll_token', $request->polltoken)->delete();
            $poll = Poll::where('token',$request->polltoken)->first();
            $poll->title=$request->polltitle;
            $poll->description=$request->polldescription;
            $poll->begin=$request->pollbegin.' '.$request->pollbegintime;
            $poll->end=$request->pollend.' '.$request->pollendtime;
            $poll->max_participants=$request->max_participants;

	    $options = DB::table('option')->where([ 'poll_token' => $request->polltoken ])->get();
            foreach (json_decode($request->options) as $option){
                    $optionsInDB = DB::table('option')->where([ ['text', $option], [ 'poll_token', $request->polltoken ] ])->get();
		    if(sizeof($optionsInDB) == 0){
			    DB::table('option')->insert(array('text' => $option, 'poll_token' => $request->polltoken) );
			    continue;
		    }
            }
	    foreach ($options as $option){
		$break=false;
		foreach (json_decode($request->options) as $o){
        	    if($option->text==$o){
            		$break=true;
			break;
        	    }
    		}
		if($break) { continue; }
		DB::table('option')->where('id', $option->id)->delete();
	    }

            DB::table('poll')->where('token',$poll->token)->update(array('title'=>$request->polltitle, 'description'=>$request->polldescription, 'begin'=>$poll->begin, 'end'=>$poll->end, 'max_participants'=>$poll->max_participants));
            DB::commit();
                    return redirect(route('Poll.showPollOverview', ['message'=>58]));

            } catch (Exception $e) {
                   DB::rollBack();
                    return parent::report($e);
                }
            }
        }
	return redirect(route('Home.showLogin', ['message' => 3]));
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
                return view('joinpollview', [ 'poll' => Poll::where('token',$request->poll_id)->first(), 'message' => $request->message]);
            }
        }
	return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function showAssessView(Request $request)
    {
    $poll = Poll::where('token',$request->poll_id)->first();
/*    if($poll->current_participants >= $poll->max_participants) { return redirect(route('Poll.showInputPollTokenView', ['message' => 12])); }
       DB::table('poll')->increment('current_participants'); */
    //to check if the user already has voted
            /* if($request->session()->has('poll_token')){
                $arr = $request->session()->get('poll_token');
                //$arr = array();
                if(in_array($poll->token, $arr)) { return redirect(route('Poll.showInputPollTokenView', ['message' => 13])); }
                array_push($arr, $poll->token);
                $request->session()->put('poll_token', $arr);
            } else {
                $request->session()->put('poll_token', [ $poll->token ]);
            } */
	if($poll->current_participants >= $poll->max_participants) { return redirect(route('Poll.showInputPollTokenView', ['message' => 12])); }
//       DB::table('poll')->increment('current_participants');
    if(!($poll->begin < date('Y-m-d H:i:s') && $poll->end > date('Y-m-d H:i:s'))){
        return view('waitingview', [ 'poll' => Poll::where('token',$request->poll_id)->first(), 'message' => $request->message]);
    } else {
        if($poll->begin < date('Y-m-d H:i:s') && $poll->end > date('Y-m-d H:i:s')) {
            if($request->session()->has('poll_token')){
                $arr = $request->session()->get('poll_token');
                //$arr = array();
                if(in_array($poll->token, $arr)) { return redirect(route('Poll.showInputPollTokenView', ['message' => 13])); }
                array_push($arr, $poll->token);
                $request->session()->put('poll_token', $arr);
            } else {
                $request->session()->put('poll_token', [ $poll->token ]);
            }
	    DB::table('poll')->increment('current_participants');
	    return view('pollassess', [ 'poll' => Poll::where('token',$request->poll_id)->first(), 'message' => $request->message, 'options'=>DB::table('option')->where('poll_token', $request->poll_id)->get()]);
        }
        return redirect(route('Home.showStartPage', ['message'=>11]));

    }
    }

    public function showInputPollTokenView(Request $request)
    {
        return view('inputpolltoken', [ 'message' => $request->message]);
    }

    // verifies the token
    public function inputToken(Request $request){
        try {
            if(!validateInputs([ $request->token ])) { return redirect(route('Poll.showPollTokenView', ['message' => 1])); }
            $token=$request->token;
            $pollInDB=DB::table('poll')->where('token', $token)->first();
	    /* if($pollInDB->current_participants >= $pollInDB->max_participants) { return redirect(route('Poll.showInputPollTokenView', ['message' => 12])); }
	    DB::table('poll')->increment('current_participants');

	    //to check if the user already has voted
            if($request->session()->has('poll_token')){
		$arr = $request->session()->get('poll_token');
		//$arr = array();
		if(in_array($pollInDB->token, $arr)) { return redirect(route('Poll.showInputPollTokenView', ['message' => 13])); }
		array_push($arr, $pollInDB->token);
		$request->session()->put('poll_token', $arr);
	    } else {
		$request->session()->put('poll_token', [ $pollInDB->token ]);
	    }*/

	   // $options = DB::table('option')->where('poll_token', $token)->get();
            
	    return redirect(route('Poll.showAssessView', ['poll_id' => $token ]));
            }
        catch (Exception $e) {
            return redirect(route('Poll.showInputPollTokenView', ['message' => 4])); // token not in db
        }
    }

    public function addPoints(Request $request)
    {
    try {
            DB::beginTransaction();
            foreach ($request->points as $optionid => $points){
            DB::table('point')->insert(array('points' => $points, 'option_id' => $optionid) );
            }

        DB::commit();
            return redirect(route('Home.showStartPage', ['message'=>53]));

        } catch (Exception $e) {
	DB::rollBack();
            return parent::report($e);
        }
    }

    public function showPollStatistics(Request $request)
    {
        //check if Election Group Leader is logged in
        if(Session::has('role')){
            if(Session::get('role')==0){
        $statistics = DB::select('SELECT o.text as otext, s.oaverage FROM option o JOIN (SELECT o.id as id, avg(p.points) as oaverage FROM option o JOIN point p ON (o.id=p.option_id) WHERE o.poll_token=:token GROUP BY o.id) s on (s.id=o.id);', ['token' => $request->poll_id]);

                return view('pollstatistics', [ 'poll' => Poll::where('token',$request->poll_id)->first(), 'statistics' => $statistics, 'message' => $request->message]);
            }
        }
	return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function showPollStatisticsOverview(Request $request)
    {
        //check if Election Group Leader is logged in
        if(Session::has('role')){
            if(Session::get('role')==0){
                return view('pollstatisticsoverview', [ 'polls' => Poll::all(), 'message' => $request->message]);
            }
        }
	return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function isPollStarted(Request $request) {
	$poll = Poll::where('token',$request->poll_id)->first();
	$isStarted = $poll->begin < date('Y-m-d H:i:s') && $poll->end > date('Y-m-d H:i:s');
	return response()->json([
            'isStarted'    => $isStarted,
        ], 200);
    }
}
