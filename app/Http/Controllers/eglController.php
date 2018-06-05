<?php
//set namespace
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
//include function for input validation
include(app_path().'/includes/validation.php');
/*
The EqlController class is responsible for almost every action that can be found on the Election Group Leader page.
It contains methods that create tokens for the corresponding election, shows the startpage and generates a PDF-file for the Election Group Leader which contains all tokens for an Election Group.
*/
class EglController extends Controller
{
	//Generates the tokens for an election group for an election and saves them in the database
	 public function generateTokenlist(Request $request) {
    	try {
	    if(!validateInputs([ Input::get('election_id'), Input::get('election_group_id'), Input::get('amount') ])) { return redirect(route('egl.showStartPage', ['message' => 1])); }
            $eId=Input::get('election_id');
            $election=Election::findOrFail($eId);
-	        if($election->election_begin == null || ($election->election_begin < date('Y-m-d H:i:s') && $election->election_end > date('Y-m-d H:i:s'))) {
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
    		} else { return redirect(route('egl.showStartPage', ['message'=>11])); }
    	} catch (Exception $e) {
    		DB::rollBack();
    		return parent::report($e);
    	}
    }

    //Generates the token string
    private function generateRandomString($length = 15) {
    	//In order to avoid confusion, only certain characters are used for the token generation
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
    	//check if Election Group Leader is logged in
        if(Session::has('role')){
            if(Session::get('role')==0){
            	//get the user
                $user_id=DB::table('user')->where('username',Session::get('username'))->value('id');

                //Select the Election Group IDs and Election IDs in order to get information about the supervised groups of the user above
                $electionElectiongroups=DB::table('user')
                                        ->select(DB::raw('election_election_group.election_id as eleid, election_group.id as elegroupid'))
                                        ->join('election_group','election_group.user_id','=','user.id')
                                        ->join('election_election_group','election_election_group.election_group_id','=','election_group.id')
                                        ->where('user.id',$user_id)->get();
                //get all elections
                $elections=Election::all();
                //get all electiongroups
                $election_group=ElectionGroup::all();

                return view('eglstartpage',array('supervisedGroupsperElection'=>$electionElectiongroups, 'elections'=>$elections, 'electiongroups'=>$election_group, 'message' => $request->message));
            }
        }
        return redirect('/');
    }
    //Generates a token list for the Election Group Leader
    public function showTokenList(Request $request){
    	    	//check if Election Group Leader is logged in
    	if(Session::has('role')){
    		if(Session::get('role')==0){
    				//Get all tokens for a group and an election
 			$tokens = DB::table('token')
					->where('election_id', $request->electionid)
					->where('election_group_id', $request->electiongroupid)->get();
		//Get the name of the election			
		$electionname=DB::table('election')
						->select('name')
						->where('id', $request->electionid)->get();
		//Get the name of the Election Group
		$election_group_name=DB::table('election_group')
								->select('name')
								->where('id', $request->electiongroupid)->get();

		//Generate a PDF-file for the tokens with TCPDF. For further information: https://tcpdf.org/
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
