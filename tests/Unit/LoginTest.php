<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

/*
 * run test:
 * ./vendor/bin/phpunit tests/Unit/VoteTest.php
*/

class LoginTest extends TestCase
{
    use RefreshDatabase;

    // function from eglController
    public function testLogin()
    {
    	try {
	    	DB::beginTransaction();
	    	DB::table('user')->insert(array('id'=>1, 'username'=>"unit", 'password'=>"unit", 'type'=>0));
	    	DB::table('user')->insert(array('id'=>2, 'username'=>"unit2", 'password'=>"unit2", 'type'=>1));

	    	$userandpass="unit";
            $users=array(
                0 => 0,
                1 => 1
            );
	        foreach ($users as $user) {
	            $this->assertDatabaseHas('user',array('id' => $user, 'username' => $userandpass, 'password'=>$userandpass, 'type'=>$user));
        	}

        } catch(Exception $e){
        	DB::rollBack();
            $this->assertTrue(false);
        }
    }

}
