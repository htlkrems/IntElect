<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

/*
 * run test:
 * ./vendor/bin/phpunit tests/Unit/VoteTest.php
*/

class VoteTest extends TestCase
{
    use RefreshDatabase;

    // function from eglController
    public function testVote()
    {
    	try {
	    	DB::beginTransaction();
	    	DB::table('user')->insert(array('id'=>1, 'username'=>"unit", 'password'=>"unit", 'type'=>0));
	        DB::table('election')->insert(array('id'=>1, 'name'=>"unit", 'type'=>0));
	        DB::table('election_group')->insert(array('id'=>1, 'name'=>"unit", 'member_count'=>30, 'user_id'=>1));
	        DB::table('candidate')->insert(array('id'=>1, 'name'=> "unit1", 'description'=>"desc", 'verified'=> true, 'election_id'=>1, ));
	        DB::table('candidate')->insert(array('id'=>2, 'name'=> "unit2", 'description'=>"desc", 'verified'=> true, 'election_id'=>1, ));

	        $votes=array(
	        	1 => 0,
	        	2 => 1
	        );
	        $electionGroupId=1;
	        
	        foreach ($votes as $candidateId => $vote) {
	            if($vote>0){
	                DB::table('vote')->insert(
	                array('points' => $vote,
	                'election_group_id' => $electionGroupId,
	                'candidate_id' => $candidateId));
	            }
        	}
        	foreach ($votes as $candidateId => $vote) {
		    if($vote>0){
        		$this->assertDatabaseHas('vote', array('points' => $vote, 
                                                  'election_group_id' => $electionGroupId,
                                                  'candidate_id' => $candidateId)
                                        );
		    }
        	}

        } catch(Exception $e){
        	DB::rollBack();
            $this->assertTrue(false);
        }
    }

}
