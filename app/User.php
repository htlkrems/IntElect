<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class User extends Model implements Authenticatable
{
    use AuthenticableTrait;
	protected $table='user';
	protected $primarykey = 'user_id';
	public $timestamps = false;
	protected $dates = ['deleted_at'];
}
