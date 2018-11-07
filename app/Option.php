<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
	protected $table='option';
	protected $primarykey = 'id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];
}
