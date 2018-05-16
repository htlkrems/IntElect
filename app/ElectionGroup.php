<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElectionGroup extends Model
{
    protected $table='election_group';
	protected $primarykey = 'election_group_id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];

	public function election(){
		return $this->belongsToMany('App\Election', 'election_election_group', 'election_group_id', 'election_id');
	}
}
