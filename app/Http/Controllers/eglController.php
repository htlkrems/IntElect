<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Candidate;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use PDF;
use DB;
use View;
use Session;
use App\Election;
use App\ElectionGroup;

include(app_path().'/includes/validation.php');

class EglController extends Controller
{
	 public function generateTokenlist(Request $request) {
    	try {
	    if(!validateInputs([ Input::get('election_id'), Input::get('election_group_id'), Input::get('amount') ])) { return redirect(route('egl.showStartPage', ['message' => 1])); }
            $eId=Input::get('election_id');
            $egId=Input::get('election_group_id');
            $amount=Input::get('amount');
    		DB::beginTransaction();
    		for ($i=0; $i < $amount; $i++) { 
    			$token=$this->generateRandomString();
				$tokenInDb = DB::table('token')
				    ->where('token', '=', $token)
					->first();
				if (is_null($tokenInDb)) {
					DB::table('token')->insert(
					    array('token' => $token,
					          'already_used' => false,
					          'election_group_id' => $egId,
					          'election_id' => $eId)
					);
				} else {
					$i--;
					continue;
				}
    		}
    		DB::commit();
    		return redirect(route('egl.showStartPage', ['message'=>56]));
    	} catch (Exception $e) {
    		DB::rollBack();
    		return parent::report($e);
    	}
    }

    private function generateRandomString($length = 15) {
    	$characters = '23456789ABCDEGHJKLMNPRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) {
    	    $randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
	}

	public function showStartpage(Request $request)
    {
        if(Session::has('role')){
            if(Session::get('role')==0){
                $user_id=DB::table('user')->where('username',Session::get('username'))->value('id');

                $electionElectiongroups=DB::table('user')
                                        ->select(DB::raw('election_election_group.election_id as eleid, election_group.id as elegroupid'))
                                        ->join('election_group','election_group.user_id','=','user.id')
                                        ->join('election_election_group','election_election_group.election_group_id','=','election_group.id')
                                        ->where('user.id',$user_id)->get();
                $elections=Election::all();
                $election_group=ElectionGroup::all();

                return view('eglstartpage',array('supervisedGroupsperElection'=>$electionElectiongroups, 'elections'=>$elections, 'electiongroups'=>$election_group, 'message' => $request->message));
            }
        }
        return redirect('/');
    }

    public function showTokenList(Request $request){
    	if(Session::has('role')){
    		if(Session::get('role')==0){
    				$tokens = DB::table('token')
					->where('election_id', $request->electionid)
					->where('election_group_id', $request->electiongroupid)->get();
		$electionname=DB::table('election')
						->select('name')
						->where('id', $request->electionid)->get();
		$election_group_name=DB::table('election_group')
								->select('name')
								->where('id', $request->electiongroupid)->get();

		PDF::SetTitle('.:: IntElect - Tokens für '.$electionname[0]->name.' ::.');
		PDF::SetAuthor('IntElect');
		PDF::SetSubject('TokenPDF für Wahlgruppe');
		PDF::SetKeywords('Token, PDF');

		PDF::setPrintHeader(false);
		PDF::setPrintFooter(false);

		PDF::AddPage();
		PDF::SetFont('times', 14);
		PDF::SetAutoPageBreak(true, 0);

        $pdfview=View::make('tokenlist',array('tokens'=>$tokens, 'electionname'=>$electionname, 'election_group_name'=>$election_group_name));
        $html=$pdfview->render();


        PDF::writeHTML($html, true, false, true, false, '');

        PDF::Output('tokens.pdf','I');
    }else{  return redirect(route('Home.showLogin', ['message' => 3])); }
}else{ return redirect(route('Home.showLogin', ['message' => 3])); }
}
}
