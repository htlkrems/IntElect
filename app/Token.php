<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
	protected $table='token';
	protected $primarykey = 'token';
	public $timestamps = false;
	protected $dates = ['deleted_at'];
}
