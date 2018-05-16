<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use DB;

class StatisticsTest extends TestCase
{
    /**
     * run test:
     * ./vendor/bin/phpunit tests/Unit/StatisticsTest.php
     */
    use RefreshDatabase;
    public function testStatistics()
    {
	try {
		$election_id=1;
		DB::unprepared(file_get_contents('public/intelect_dummy.sql'));
		$winning_order=['Hans Moser, 3BTTHD', 'Charlie Chapplin, 3AHIT', 'Stanly Kubrik, 6YBKT'];

		// query from the statistics controller
	        $statistics=DB::select('SELECT concat(c.name,", ",c.party) AS "name", s.points FROM candidate c JOIN (SELECT sum(v.points) AS "points", c.id FROM election e JOIN candidate c on e.id= c.election_id JOIN vote v on v.candidate_id=c.id WHERE e.id=:id GROUP BY c.id) s ON c.id = s.id ORDER BY points DESC;', ['id' => $election_id]);

		$this->assertNotNull($statistics);

		for($i=0; $i<sizeof($winning_order); $i++){
			$this->assertEquals($winning_order[$i], $statistics[$i]->name);
		}
	}
	catch(Exception $e){
		$this-assertTrue(false);
	}
    }
}
