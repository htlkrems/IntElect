<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
	protected $table='vote';
	protected $primarykey = 'vote_id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];
}
