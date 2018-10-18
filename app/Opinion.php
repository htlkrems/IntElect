<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
	protected $table='opinion';
	protected $primarykey = 'id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];
}
