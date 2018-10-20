<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
	protected $table='point';
	protected $primarykey = 'id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];
}
 
