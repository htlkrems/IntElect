 <?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
	protected $table='poll';
	protected $primarykey = 'token';
	public $timestamps = false;
	protected $dates = ['deleted_at'];
}
