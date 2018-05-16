<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
	protected $table='candidate';
	protected $primarykey = 'candidate_id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];
}
