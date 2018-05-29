<?php
//set namespace
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use PDF;
use App\Candidate;
use App\ElectionGroup;
use App\Election;
use DB;
use View;
use Session;
//include method for input validation
include(app_path().'/includes/validation.php');
/*
    The StatisticsController provides functionality for statistics.
*/
class StatisticsController extends Controller
{
    //Shows the RunningElections page
    public function showRunningElections(){
        $runningelections=DB::table('election')->where('election_end','>=',date('Y-m-d H:i:s'))
                                         ->orWhereNull('election_end')->get();
        return view('runningelections', ['elections'=>$runningelections]);
    }
    //Shows the ClosedElections page
    public function showClosedElections()
    {
        $closedelections=DB::table('election')->where('election_end','<=',date('Y-m-d H:i:s'))
                                         ->orWhereNull('election_end')->get();
        return view('closedelections',['elections'=>$closedelections]);
    }
    //Shows the Info page
    public function showInfo(Request $request) {
        $election=Election::where('id', $request->election_id)->first();
        $candidates = DB::table('candidate')
                        ->where([ ['election_id', $request->election_id], ['verified', 1]])->get();
        return view('electioninfo',['election'=>$election,'candidates'=>$candidates]);
    }
    //Shows the statistics with charts
    public function showChart(Request $request){
        //return View::make('statistics.showChart')->with('election', 1);
        return view('electionstatistics', ['election' => Election::findOrFail($request->electionId), 'statistics' => DB::select('SELECT concat(c.name,", ",c.party) AS "name", s.points FROM candidate c JOIN (SELECT sum(v.points) AS "points", c.id FROM election e JOIN candidate c on e.id= c.election_id JOIN vote v on v.candidate_id=c.id WHERE e.id=:id GROUP BY c.id) s ON c.id = s.id;', ['id' => $request->electionId])]);
    }
    //Generates the Report for the LSR
    public function generateReport(Request $request){
        if(Session::has('role')){
            if(Session::get('role')==1){
        //Gets all candidates
        $candidates = DB::table('candidate')
                        ->where('election_id', $request->election_id)->get();
        //Gets all Election Groups
        $electiongroups=DB::table('election_group')
                        ->join('election_election_group','election_group.id','=','election_election_group.election_group_id')
                        ->where('election_election_group.election_id', $request->election_id)->get();
        //Gets the election
        $election=Election::where('id', $request->election_id)->first();
        //Gets the results from the vote process
        $voteResults=DB::table('vote')
                    ->select(DB::raw('sum(vote.points) AS gcpoints, candidate.id AS can_id, election_group.id AS eleg_id'))
                    ->join('candidate','vote.candidate_id','=','candidate.id')
                    ->join('election_group','vote.election_group_id','=','election_group.id')
                    ->where('candidate.election_id',$request->election_id)
                    ->groupBy("candidate.id","election_group.id")->get();
        //Get the amount of valid votes
        $validVotesPerGroup=DB::table('election_group')
                            ->select(DB::raw('count(token.token) AS countvalidvotes,  election_group.id AS eleg_id'))
                            ->join('token','token.election_group_id','=','election_group.id')
                            ->where('token.valid_vote',1)
                            ->where('token.election_id',$request->election_id)
                            ->groupBy("election_group.id")->get();
        //Get the amount of votes of an Election Group for a certain candidate with six points
        $voteResultssixPoints=DB::table('vote')
                    ->select(DB::raw('count(vote.id) AS sixpointscount, candidate.id AS can_id, election_group.id AS eleg_id'))
                    ->join('candidate','vote.candidate_id','=','candidate.id')
                    ->join('election_group','vote.election_group_id','=','election_group.id')
                    ->where('candidate.election_id',$request->election_id)
                    ->where('vote.points',6)
                    ->groupBy("candidate.id","election_group.id")->get();
        if($election->type==0){
            //Get the amount of votes of an Election Group for a certain candidate with one point
            $voteResultssixPoints=DB::table('vote')
                    ->select(DB::raw('count(vote.id) AS sixpointscount, candidate.id AS can_id, election_group.id AS eleg_id'))
                    ->join('candidate','vote.candidate_id','=','candidate.id')
                    ->join('election_group','vote.election_group_id','=','election_group.id')
                    ->where('candidate.election_id',$request->election_id)
                    ->where('vote.points',1)
                    ->groupBy("candidate.id","election_group.id")->get();
        }
        //Gets the order of the candidates by votes
          $candidatewinorder = DB::table('vote')
                    ->select(DB::raw('candidate.id AS can_id, sum(vote.points) AS canpoints'))
                    ->join('candidate','vote.candidate_id','=','candidate.id')
                    ->join('election_group','vote.election_group_id','=','election_group.id')
                    ->where('candidate.election_id',$request->election_id)
                    ->groupBy('candidate.id')
                    ->orderBy('canpoints','desc')->offset(0)->limit(7)->get();
        
        //Generate a PDF-file for the report with TCPDF. For further information: https://tcpdf.org/
        PDF::SetTitle('.:: Intelect - Bericht '.$election->name.' ::.');
        PDF::SetAuthor('IntElect');
        PDF::SetSubject('LSRReportPDF');
        PDF::SetKeywords('Wahlergebnisse, PDF');

        PDF::setPrintHeader(false);
        PDF::setPrintFooter(false);

        PDF::AddPage();
        PDF::SetFont('times', 14);
        PDF::SetAutoPageBreak(true, 0);

        $pdfview=View::make('lsrreport',array('electiongroups'=>$electiongroups, 'candidates'=>$candidates,'election'=>$election, 'voteResults'=>$voteResults, 'validVotesPerGroup'=>$validVotesPerGroup, 'voteResultssixPoints'=>$voteResultssixPoints, 'winners'=>$candidatewinorder));
        $html=$pdfview->render();

        PDF::writeHTML($html, true, false, true, false, '');

        PDF::Output('lsrbericht.pdf','I');
            }else{return redirect(route('Home.showLogin', ['message' => 3]));}
}else{return redirect(route('Home.showLogin', ['message' => 3]));}
    }
}
