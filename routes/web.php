<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$proxy_url    = getenv('PROXY_URL');
$proxy_scheme = getenv('PROXY_SCHEME');

if (!empty($proxy_url)) {
   URL::forceRootUrl($proxy_url);
}
if (!empty($proxy_scheme)) {
   URL::forceScheme($proxy_scheme);
}

// ---- poll module routes ----
Route::get('/joinpoll/{polltoken}', 'PollController@showJoinPollView')->name('Poll.showJoinPollView');


Route::get('/', 'HomeController@showStartpage')->name('Home.showStartPage');
//route to show the register form
Route::get('registerasCandidate', 'HomeController@showRegister')->name('Home.showRegister');
//route to process the register form
Route::post('registerasCandidate', 'HomeController@Register')->name('Home.Register');
// route to show the login form
Route::get('/login', array('uses' => 'HomeController@showLogin'))->name('Home.showLogin');
// route to process the form
Route::post('/login', array('uses' => 'HomeController@login'))->name('Home.Login');
//get the token pdf
Route::get('egl/tokens/{electionid}/{electiongroupid}', 'EglController@showTokenList')->name('egl.showTokenList');
//get the lsrreport pdf
Route::get('statistics/generateReport/{election_id}','StatisticsController@generateReport')->name('Statistics.generateReport');
//show statistics in a diagram
Route::get('/statistics/showChart/{electionId}', array('uses' => 'StatisticsController@showChart'))->name('Statistics.showChart');
//logout
Route::get('logout', 'HomeController@logout')->name('Home.logout');
//showRunningElections
Route::get('statistics/showRunningElections', 'StatisticsController@showRunningElections')->name('Statistics.showRunningElections');
//showClosedElections
Route::get('statistics/showClosedElections','StatisticsController@showClosedElections')->name('Statistics.showClosedElections');
//showInfo of Election
Route::get('/statistics/info/{election_id}',array('uses'=>'StatisticsController@showInfo'))->name('Statistics.showInfo');
//eglStartPage
Route::get('egl','eglController@showStartPage')->name('egl.showStartPage');
//generate Tokens
Route::post('egl','eglController@generateTokenlist')->name('egl.generateTokenlist');
//showElectionInfo vote
Route::get('vote/{electionid}/info','VoteController@showElectionInfo')->name('Vote.showElectionInfo');
//showVotingMask
Route::get('vote/{electionid}/elect','VoteController@showVotingMask')->name('Vote.showVotingMask');
//elect
Route::post('vote/elect','VoteController@elect')->name('Vote.elect');
//showTokenMask
Route::get('vote','VoteController@showTokenMask')->name('Vote.showTokenMask');
//inputToken
Route::post('vote','VoteController@inputToken')->name('Vote.inputToken');
//createElection
Route::get('admin','AdminController@showStartPage')->name('admin.showStartPage');
//showElectionGroups
Route::get('admin/eg','AdminController@showElectionGroups')->name('admin.showElectionGroups');
//showEGEdit
Route::get('admin/eg/{egid}/edit','AdminController@showEGEdit')->name('admin.showEGEdit');
//edit EG
Route::post('admin/eg/edit','AdminController@editEG')->name('admin.editEG');
//deleteEG
Route::get('admin/eg/{egid}/delete','AdminController@deleteEG')->name('admin.deleteEG');
//showegcreate
Route::get('admin/eg/create','AdminController@showEGCreate')->name('admin.showEGCreate');
//showeditElection
Route::get('admin/election/edit/{eId}','AdminController@showElectionEdit')->name('admin.showElectionEdit');
//closeElection
Route::get('admin/election/{eId}/close','AdminController@closeElection')->name('admin.closeElection');
//showcreateElection
Route::get('admin/election/create','AdminController@showElectionCreate')->name('admin.showElectionCreate');
//createElection
Route::post('admin/election/create','AdminController@createElection')->name('admin.createElection');
//verifyCandidate
Route::get('admin/{id}/verify', 'AdminController@verifyCandidate')->name('admin.verifyUser');
//denyCandidate
Route::get('admin/{id}/deny', 'AdminController@denyCandidate')->name('admin.denyCandidate');
//showchangePassword
Route::get('changePassword','HomeController@showChangePassword')->name('Home.showChangePassword');
//changePassword
Route::post('changePassword','HomeController@changePassword')->name('Home.changePassword');
//editUser
Route::get('admin/users/{id}/edit','AdminController@showUsersEdit')->name('Admin.showUsersEdit');
//editUser
Route::post('admin/users/edit','AdminController@editUser')->name('Admin.editUser');
//showUsers
Route::get('admin/users','AdminController@showUsers')->name('admin.showUsers');
//createElectionGroup
Route::post('admin/eg/create','AdminController@createElectionGroup')->name('admin.createElectionGroup');
//electionOverview
Route::get('admin/election','AdminController@showElections')->name('admin.showElectionOverview');
//deleteElection
Route::get('admin/election/{e_id}/delete','AdminController@deleteElection')->name('admin.deleteElection');
//election edit
Route::post('/admin/election/edit/',array('uses'=>'AdminController@electionEdit'))->name('Admin.editElection');
//edit election candidate
Route::post('/admin/election/edit/candidate/',array('uses'=>'AdminController@electionCandidateEdit'))->name('Admin.editElectionCandidate');
//remove election candidate
Route::post('/admin/election/edit/candidate/remove',array('uses'=>'AdminController@removeCandidate'))->name('Admin.removeCandidate');
//removeElectiongroup
Route::get('/admin/election/edit/{election_id}/eg/remove/{election_group_id}',array('uses'=>'AdminController@removeEG'))->name('Admin.removeEG');
//add Electiongroup
Route::post('/admin/election/edit/eg/add',array('uses'=>'AdminController@addEG'))->name('Admin.addEG');
// delete user
Route::get('admin/user/delete/{u_id}','AdminController@deleteUser')->name('admin.deleteUser');
//create user
Route::post('admin/user/create','AdminController@createUser')->name('admin.createUser');
//show create user
Route::get('admin/user/create','AdminController@showUserCreate')->name('admin.showUserCreate');


// Intelect - Poll module
//show create g
Route::get('/egl/polls/create','PollController@showCreatePollView')->name('Poll.showCreatePollView');
//create g
Route::post('/egl/polls/create','PollController@createPoll')->name('Poll.createPoll');
//show update g
Route::get('/egl/polls/{poll_id}/update','PollController@showUpdatePollView')->name('Poll.showUpdatePollView');
//update gn
Route::post('/egl/polls/{poll_id}/update','PollController@updatePoll')->name('Poll.updatePoll');
//delete g
Route::get('/egl/polls/{poll_id}/delete','PollController@deletePoll')->name('Poll.deletePoll');

//showJoinPollView - M
Route::get('/polls/{poll_id}/join','PollController@showJoinPollView')->name('Poll.showJoinPollView');

//showAssessView
Route::get('/polls/{poll_id}/assess','PollController@showAssessView')->name('Poll.showAssessView');
//inputPollTokenView
Route::get('/polls/inputToken','PollController@inputPollTokenView')->name('Poll.inputPollTokenView');
//waitforstart
Route::get('/polls/{poll_id}/waitingforstart','PollController@showWaitingPage')->name('Poll.showWaitingPage');

Route::get('/polls/{poll_id}/assess','PollController@showAssessView')->name('Poll.assessment');

Route::post('/polls/{poll_id}/assess','PollController@addPoints')->name('Poll.assess');

Route::get('/egl/polls/{poll_id}/statistics','PollController@showPollStatistics')->name('Poll.showPollStatistics');
