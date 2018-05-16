<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
	protected $table='election';
	protected $primarykey = 'election_id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];

	public function electiongroup(){
		return $this->belongsToMany('App\ElectionGroup', 'election_election_group', 'election_id', 'election_group_id');
	}
}
