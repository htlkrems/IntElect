<?php
//set the namespace
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Election;
use Session;
use App\ElectionGroup;
use Exception;
use App\Token;
//include a method for input validation
include(app_path().'/includes/validation.php');
/*
    The VoteController provides the functionality for the vote-part.
*/
class VoteController extends Controller {

    //Shows the Tokenmask for voters
    public function showTokenMask(Request $request) {
        return view('tokenmask', ['message' => $request->message]);
    }
    //Shows the votingmask at  the end of the election process
    public function showVotingMask(Request $request) {
        try{
            $tokenInDB=DB::table('token')->where('token', Session::get('token'))->first();
            if($tokenInDB->already_used==0){
                DB::table('token')->where('token', Session::get('token'))->update(['already_used' => true ]);
                return view('votingmask', ['election' => DB::table('election')->where('election_end','>=',date('Y-m-d H:i:s'))->where('id',$request->electionid)->orWhereNull('election_end')->first(), 'candidates' => DB::table('candidate')->where('election_id', $request->electionid)->where('verified',1)->get(),'election_group'=>ElectionGroup::findOrFail($tokenInDB->election_group_id),'token'=>$tokenInDB]);
            } else {
                return redirect(route('Vote.showTokenMask'));
            }
        }
        catch (Exception $e){
            return redirect(route('Vote.showTokenMask'));
        }
    }
    //Show ElectionInfo page
    public function showElectionInfo(Request $request) {
        try{
	   if(!validateInputs([ $request->electionid ])) { return redirect(route('Vote.showTokenMask', ['message' => 1])); }
            return view('voteelectioninfo', ['election' => DB::table('election')->where('election_end','>=',date('Y-m-d H:i:s'))->where('id',$request->electionid)->orWhereNull('election_end')->first(), 'candidates' => DB::table('candidate')->where('election_id', $request->electionid)->where('verified',1)->get()]);
            }
        catch (Execption $e){
            return redirect(route('Vote.showTokenMask'));
        }}
    // verifies the token
    public function inputToken(Request $request){
        try {
	    if(!validateInputs([ $request->token ])) { return redirect(route('Vote.showTokenMask', ['message' => 1])); }
            $token=$request->token;
            $tokenInDB=DB::table('token')->where('token', $token)->first();
                $request->session()->put('token', $token);
            $election=Election::where('id', $tokenInDB->election_id)->first();
            if($tokenInDB->already_used==0){
                return redirect(route('Vote.showElectionInfo',['electionid'=>$election->id]));
            } else {
                return redirect(route('Vote.showTokenMask', ['message' => 5])); // token already used
        }
            }
        catch (Exception $e) {
            return redirect(route('Vote.showTokenMask', ['message' => 4])); // token not in db
        }
    }
    
    //Vote for candidates
    public function elect(Request $request){
	try {
        DB::beginTransaction();
	if(!validateInputs([ $request->electiongroupid, $request->electionid ])) { return redirect(route('Vote.showTokenMask', ['message' => 1])); }
        $votes=$request->votes;
        $electionGroupId=$request->electiongroupid;
        $election = Election::findOrFail($request->electionid);
        foreach ($votes as $candidateId => $vote) {
            $checker = 0;
            //check if the vote is valid
            foreach ($votes as $candidateIds => $votevalue) {
                if($votevalue!=0&&$vote!=0){
                if($votevalue==$vote){
                    $checker++;
                }}
                if($checker==2){
                    return redirect(route('Vote.showTokenMask', ['message' => 6]));
                }
            }
            if($vote>0){
                DB::table('vote')->insert(
                array('points' => $vote,
                'election_group_id' => $electionGroupId,
                'candidate_id' => $candidateId));
            }
            DB::table('token')->where('token', $request->token)->update(['valid_vote' => true ]);
        }
	DB::commit();
	} catch (Exception $e) {
		DB::rollBack();
		return redirect(route('Vote.showTokenMask', ['message' => 0]));
	}
        return redirect(route('Home.showStartPage', ['message'=>53]));
    }
}

?>
