<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

/*
 * run test:
 * ./vendor/bin/phpunit tests/Unit/TokenTest.php
*/

class TokenTest extends TestCase
{
    use RefreshDatabase;

    // function from eglController
    public function testGenerateToken()
    {
        try {
            $eId=1;
            $egId=1;
            $amount=30;
            $tokenList=array();
                DB::beginTransaction();

                // insert needed testdata into the db
                DB::table('user')->insert(array('id'=>1, 'username'=>"unit", 'password'=>"unit", 'type'=>0));
                DB::table('election')->insert(array('id'=>1, 'name'=>"unit", 'type'=>0));
                DB::table('election_group')->insert(array('id'=>1, 'name'=>"unit", 'member_count'=>30, 'user_id'=>1));
                
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
                                        $tokenList[$i]=$token;
                                } else {
                                        $i--;
                                        continue;
                                }
                }
                DB::commit();

                $table=DB::table('token')->get();

                for ($i=0; $i < $amount; $i++) { 
                        $this->assertDatabaseHas('token', array('token' => $tokenList[$i], 
                                                  'already_used' => false,
                                                  'election_group_id' => $egId,
                                                  'election_id' => $eId)
                                        );
                }
        } catch (Exception $e) {
                DB::rollBack();
                $this->assertTrue(false);
        }
         
    }

    // function from eglController
    private function generateRandomString($length = 15) {
        $characters = '23456789ABCDEGHJKLMNPRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
        }
}