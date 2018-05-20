<?php

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
use App\Election;
use App\ElectionGroup;

include(app_path().'/includes/validation.php');

class AdminController extends Controller
{

   public function showStartPage(Request $request)
    {
        if (Session::has('role')) {
            if (Session::get('role') == 1) {
                $closedelections = DB::table('election')
                                    ->where('election_end', '<=', date('Y-m-d H:i:s'))
                                    ->orWhereNull('election_end')
                                    ->orderBy('election_end','desc')
                                    ->take(5)
                                    ->get();
                $runningelections = DB::table('election')
                                    ->where('election_end','>=',date('Y-m-d H:i:s'))
                                    ->orWhereNull('election_end')
                                    ->get();
                $verifiedcandidates=DB::table('candidate')
                                    ->where('verified',1)
                                    ->get();
                $unverifiedcandidates = DB::table('candidate')
                                        ->select('candidate.id as cid', 'candidate.name as cname', 'candidate.party as cparty', 'election.name as ename')
                                        ->join('election','election.id','=','candidate.election_id')
                                        ->where('verified',0)
                                        ->get();

                return view('adminstartpage', array('runningelections' => $runningelections, 'closedelections' => $closedelections, 'unverifiedcandidates' => $unverifiedcandidates, 'verifiedcandidates'=>$verifiedcandidates, 'message'=>$request->message));
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function createUser(Request $request)
    {
        if (Session::has('role')) {
            if (Session::get('role') == 1) {
		try {
			if(!validateInputs([ $request->username ])) { return redirect(route('admin.showUserCreate', ['message'=>1]));  }
			if(DB::table('user')->where('username', '=', $request->username)->count('id')>0) { return redirect(route('admin.showUserCreate', ['message'=>9])); }
			DB::beginTransaction();
         	        $newUser = new User();

                	$newUser->username = $request->username;
                	$newUser->password = password_hash($request->password, PASSWORD_BCRYPT);
                	$newUser->type = $request->type;

                	$newUser->save();

			if($request->type==0&&!is_null($request->election_groups)){
                		foreach ($request->election_groups as $election_group_id => $item) {
                		        $election_group = ElectionGroup::find($election_group_id);
                		        $election_group->user_id = $newUser->id;
                		        $election_group->save();
                		    }
			}
			DB::commit();
		} catch (Exception $e) {
                DB::rollBack();
		return redirect(route('admin.showUsers', ['message' => 0]));
                }
                return redirect(route('admin.showUsers', ['message'=>57]));
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function editUser(Request $request){
        if (Session::has('role')) {
            if (Session::get('role') == 1) {
		try {
			if(!validateInputs([ $request->username ])) { return redirect(route('admin.showUsers', ['message'=>1]));  }
			$user = User::find($request->user_id);
			if($user->username!=$request->username && DB::table('user')->where('username', '=', $request->username)->count('id')>0) { return redirect(route('Admin.showUsersEdit', ['id'=>$request->user_id, 'message' => 9])); }
			DB::beginTransaction();

	                $user->username = $request->username;
	                if(!is_null($request->password)){
	                    $user->password = password_hash($request->password, PASSWORD_BCRYPT);
	                }
	                $user->save();

	                $elegroups=ElectionGroup::all();

	                foreach ($elegroups as $elegroup) {
			    if($elegroup->user_id==$request->user_id){
	                      $elegroup->user_id=null;
	                      $elegroup->save();
			    }
	                }
			if($user->type==0&&!is_null($request->election_groups)){
	                	foreach ($request->election_groups as $election_group_id => $item) {
	                        	$election_group = ElectionGroup::find($election_group_id);
        	                	$election_group->user_id = $request->user_id;
                	        	$election_group->save();
                		}
			}
			DB::commit();
		} catch (Exception $e) {
                DB::rollBack();
		return redirect(route('admin.showUsers', ['message' => 0]));
                }
		/*
                $user2 = User::find($user->id);
                $electiongroups=ElectionGroup::all();
                return view('editUser', ['user' => $user, 'electiongroups'=>$electiongroups]);*/
		return redirect(route('admin.showUsers', ['message'=>58]));
               }
		}
            return redirect(route('Home.showLogin', ['message' => 3]));
        }

    public function verifyCandidate(Request $request){
        if (Session::has('role')) {
            if (Session::get('role') == 1) {
                    $candidate = Candidate::find($request->id);
                    $candidate->verified=1;
                    $candidate->save();
                    }
                return redirect(route('admin.showStartPage', ['message'=>59]));
            }
            return redirect(route('Home.showLogin', ['message' => 3]));
        }
        
    

    public function denyCandidate(Request $request){
        if (Session::has('role')) {
            if (Session::get('role') == 1) {
                    $candidate = Candidate::where('id',$request->id);
                    $candidate->delete();
                    }
                 return redirect(route('admin.showStartPage', ['message'=>60]));
                }
                return redirect(route('Home.showLogin', ['message' => 3]));
            }

    public function showUsers(Request $request)
    {
        if (Session::has('role')) {
            if (Session::get('role') == 1) {
                //$users = DB::table('user')->get();
		$users=DB::select('SELECT z.id, username, type, election_groups FROM user JOIN ( SELECT u.id as id, group_concat(" ", eg.name) as election_groups FROM user u LEFT JOIN election_group eg on u.id = eg.user_id GROUP BY u.id) z on user.id=z.id');
                //$users=DB::table('user')->select('user.id', 'user.username', 'user.type', DB::raw('group_concat(election_group.name) as election_groups'))->join('election_group', 'user.id', '=', 'election_group.user_id')->groupBy('user.id')->get();
//		if(isset($request->message)) {return view('showUsers', ['users' => $users, 'message' => $request->message]);}
		return view('showUsers', ['users' => $users, 'message'=>$request->message]);
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function showUsersEdit(Request $request)
    {
        if (Session::has('role')) {
            if (Session::get('role') == 1) {
                $user = User::find($request->id);
                $electiongroups=DB::table('election_group')->select('election_group.id as id', 'election_group.name as name', 'user.username as username', 'user.id as user_id')->leftJoin('user', 'election_group.user_id', '=', 'user.id')->get();
                return view('editUser', ['user' => $user, 'electiongroups'=>$electiongroups, 'message'=>$request->message]);
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }

   public function showElectionGroups(Request $request)
    {
        if (Session::has('role')) {
            if (Session::get('role') == 1) {
                $electiongroups = DB::table('election_group')
                                    ->select('user.username as uname','election_group.name as name','election_group.member_count as member_count','election_group.id as egid','election_group.id as id')
                                    ->leftJoin('user','user.id','=','election_group.user_id')
                                    ->get();
                $electionegs = DB::table('election_election_group')
                                ->select('election_election_group.election_group_id as election_group_id','election.name as election_name')
                                ->join('election','election.id','=','election_election_group.election_id')
                                ->get();
                return view('adminelectiongroups', ['electiongroups' => $electiongroups,'electionegs'=>$electionegs, 'message'=>$request->message]);
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function showEGEdit(Request $request)
    {
        if (Session::has('role')) {
            if (Session::get('role') == 1) {
                $electiongroup = ElectionGroup::find($request->egid);
                $users=User::where('type', '=', '0')->get();
		return view('editEG',['electiongroup'=>$electiongroup,'users'=>$users, 'message'=>$request->message]);
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function showEGCreate(Request $request)
    {
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
		$users = DB::table('user')->where('type', 0)->pluck('id', 'username');
                return view('createEG', ['users' => $users, 'message'=>$request->message]);
            }
        }
	return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function editEG(Request $request){
		if(Session::has('role')) {
            if (Session::get('role') == 1) {
				if(!validateInputs([ $request->name, $request->numberofparticipants, $request->user_id ])) { return redirect(route('admin.showEGEdit', ['egid'=>$request->id, 'message'=>1]));  }
				$electiongroup = ElectionGroup::find($request->id);
				$electiongroup->name = $request->name;
				$electiongroup->member_count = $request->numberofparticipants;
				$electiongroup->user_id=$request->user_id;
				$electiongroup->save();
				return redirect(route('admin.showElectionGroups', ['message'=>58]));
			}
		}
		return redirect(route('Home.showLogin', ['message' => 3]));
	}
    public function getCandidatebyElection(Request $request){
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
                $candidates = DB::table('candidate')->where('election_id', $request->electionid)->get();

                return $candidates;
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function showUserCreate(Request $request)
    {
        if (Session::has('role')) {
            if (Session::get('role') == 1) {
            $electiongroups = ElectionGroup::all();
                return view('createUser', ['electiongroups' => $electiongroups, 'message'=>$request->message]);
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }
    
    public function createElectionGroup(Request $request){
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
		if(!validateInputs([ $request->name, $request->member_count, $request->users ])) { return redirect(route('admin.showEGCreate', ['message' => 1])); }
                $newElectionGroup = new ElectionGroup();

                $newElectionGroup->name= $request->name;
                $newElectionGroup->member_count=$request->member_count;

		$newElectionGroup->user_id=$request->users;
		/*
                foreach ($request->users as $user_id => $item) {
                    if ($item) {
                        $newElectionGroup->user_id=$user_id;
                        break;
                    }
                }
		*/
                $newElectionGroup->save();
                return redirect(route('admin.showElectionGroups', ['message'=>57]));
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function showElectionEdit(Request $request){
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
                $election = DB::table('election')
                                ->where('id',$request->eId)->first();
                $elegroupcount = DB::table('election_election_group')
                                    ->select(DB::raw('count(*) as elegroupcount'))
                                    ->where('election_id',$request->eId)
                                    ->groupBy('election_id')->first();
                $votercount = DB::table('election_election_group')
                                    ->select(DB::raw('sum(election_group.member_count) as votercount'))
                                    ->join('election_group','election_group.id','=','election_election_group.election_group_id')
                                    ->where('election_election_group.election_id',$request->eId)
                                    ->groupBy('election_election_group.election_id')->first();
                $candidates = DB::table('candidate')
                                ->where('election_id',$request->eId)
                                ->where('verified',1)
                                ->get();
                $electiongroupsinelection = DB::table('election_group')
                                                ->select(DB::raw('election_group.name as ename, election_group.member_count as emember_count,user.username as uname, user.id as uid, election_group.id as eid'))
                                                ->join('user','user.id','=','election_group.user_id')
                                                ->join('election_election_group','election_election_group.election_group_id','=','election_group.id')
                                                ->where('election_election_group.election_id',$request->eId)->get();
                $electiongroupsnotinelection = DB::table('election_group')
                                                ->select(DB::raw('election_group.name as ename, election_group.member_count as emember_count,user.username as uname, user.id as uid, election_group.id as eid'))
                                                ->join('user','user.id','=','election_group.user_id')
                                                ->get();
                return view('electionDetails',['votercount'=>$votercount,'elegroupcount'=>$elegroupcount,'election'=>$election, 'candidates'=>$candidates, 'electiongroupsinelection'=>$electiongroupsinelection, 'electiongroupsnotinelection'=>$electiongroupsnotinelection, 'message'=>$request->message]);
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }

	public function electionEdit(Request $request){
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
                	if(!validateInputs([ $request->e_name, $request->e_description ])) { return redirect(route('admin.showElectionEdit', ['eId'=>$request->electionid, 'message' => 1])); }
                        $election = Election::where('id',$request->electionid)->first();
                        $election->name=$request->e_name;
                        $election->description=$request->e_description;
                        $election->candidate_registration_begin=$request->e_candidate_registration_begin;
                        $election->candidate_registration_end=$request->e_candidate_registration_end;
                        $election->election_begin=$request->e_election_begin;
                        $election->election_end=$request->e_election_end;
                        $election->type=$request->e_type;
                        $election->save();
                
                return redirect(route('admin.showElectionEdit',['eId'=>$request->electionid, 'message'=>58]));

        }}
        return redirect(route('Home.showLogin', ['message' => 3]));
    }

	public function electionCandidateEdit(Request $request){
		if(Session::has('role')) {
            if (Session::get('role') == 1) {
				if(!validateInputs([ $request->c_name, $request->c_party ])) { return redirect(route('admin.showElectionEdit', ['eId'=>$request->electionid, 'message' => 1])); }
				$candidate=Candidate::find('election_id',$request->electionid);
				$candidate->name=$request->c_name;
				$candidate->party=$request->c_party;
				$candidate->save();
				return redirect(route('admin.showElectionEdit', ['eId'=>$request->electionid, 'message' => 58]));
				}
		}
		return redirect(route('Home.showLogin', ['message' => 3]));
	}
	
	public function createElection(Request $request)
    {
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
		if(!validateInputs([ $request->name, $request->description ])) { return redirect(route('admin.showStartPage', ['message'=>1])); }
                $newElection = new Election();

                $newElection->name=$request->name;
                $newElection->description=$request->description;
                $newElection->type=$request->type; // 1 = Punktesystem, 0 = Kreuzsystem
                $newElection->candidate_registration_begin=$request->candidate_registration_begin;
                $newElection->candidate_registration_end=$request->candidate_registration_end;
                $newElection->election_begin=$request->election_begin;
                $newElection->election_end=$request->election_end;
                $newElection->save();

                return redirect(route('admin.showStartPage', ['message'=>57]));
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }
    
    public function showElections(Request $request){
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
                $elections=DB::select('SELECT *, (SELECT count(election_id) FROM candidate WHERE election_id=e.id) as candidates, (SELECT count(election_id) FROM election_election_group WHERE election_id=e.id) as election_groups, (SELECT sum(member_count) FROM election_group eg JOIN election_election_group eeg ON eeg.election_group_id = eg.id WHERE eeg.election_id=e.id) AS member_count FROM election e');
                return view('electionOverview',['elections'=>$elections, 'message'=>$request->message]);
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }

    public function showElectionCreate(Request $request)
    {
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
                return view('createElection', ['message'=>$request->message]);
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }
    
    
    public function addCandidate(Request $request)
	{
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
                $newCandidate = new Candidate();
                $file = $request->file('file');
                $name= time().$file->getClientOriginalName();
                $file->move('uploads/',$name);


                $newCandidate->name= $request->firstName." ".$request->lastName;
                $newCandidate->party=$request->partyinput;
                $newCandidate->description=$request->DescriptionInput;
                $newCandidate->election_id=$request->election_id;
                $newCandidate->picture="uploads/".$name;

                $newCandidate->save();
	    
                return redirect(route('Admin.showElectionEdit',['eId'=>$request->electionid, 'message'=>61]));
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
	}
	
	public function removeCandidate(Request $request){
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
                try {
                        DB::beginTransaction();
                        DB::table('vote')->where('candidate_id',$request->candidate_id)->delete();
                        DB::table('candidate')->where('id',$request->candidate_id)->delete();
                        DB::commit();
                
                } catch (Exception $e) {
                        DB::rollBack();
			return redirect(route('admin.showElectionEdit',['eId'=>$request->election_id, 'message'=>0]));
                }
                return redirect(route('admin.showElectionEdit',['eId'=>$request->election_id, 'message'=>62]));
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }
	
	   public function addEG(Request $request){
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
                try {
                        DB::beginTransaction();
                if(!is_null($request->election_groups)){
                foreach ($request->election_groups as $election_group_id) {
                    
                        DB::table('election_election_group')->insert(
                            ['election_id' => $request->election_id, 'election_group_id' => $election_group_id]
                        );
                    }
                }
                DB::commit();
            } catch (Exception $e) {
                        DB::rollBack();
			return redirect(route('admin.showElectionEdit',['eId'=>$request->election_id, 'message'=>0]));
                }}
                return redirect(route('admin.showElectionEdit',['eId'=>$request->election_id, 'message'=>61]));
            }
            return redirect(route('Home.showLogin', ['message' => 3]));
        }
	
	public function deleteEG(Request $request){
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
                DB::table('election_group')->where([
                    ['id', '=', $request->egid]
                ])->delete();
                return redirect(route('admin.showElectionGroups', ['message'=>63]));
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
	}

	public function deleteElection(Request $request){
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
                DB::table('election')->where([
                    ['id', '=', $request->e_id]
                    ])->delete();
                return redirect(route('admin.showElectionOverview', ['message'=>63]));
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
        }

	public function deleteUser(Request $request){
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
		if(DB::table('election_group')->where('user_id', '=', $request->u_id)->count('id')>0){ return redirect(route('admin.showUsers', ['message' => 10 ])); }
                DB::table('user')->where([
                    ['id', '=', $request->u_id]
                    ])->delete();
                return redirect(route('admin.showUsers', ['message'=>63]));
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
        }

        public function removeEG(Request $request){
        if(Session::has('role')) {
            if (Session::get('role') == 1) {
                try {
                        DB::beginTransaction();
                DB::table('election_election_group')->where([
                    ['election_id', '=', $request->election_id],
                    ['election_group_id', '=', $request->election_group_id]
                ])->delete();
                DB::commit();
                } catch (Exception $e) {
                        DB::rollBack();
			return redirect(route('admin.showElectionEdit',['eId'=>$request->election_id, 'message'=>0]));
                }
                return redirect(route('admin.showElectionEdit',['eId'=>$request->election_id, 'message'=>62]));
            }
        }
        return redirect(route('Home.showLogin', ['message' => 3]));
    }
}
