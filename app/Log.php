<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'log';
	protected $primaryKey = 'id';
	public $timestamps = true;
	public $incrementing = true;

	protected $fillable = array(
		'user_id',
		'description',
		'activity'
	);

	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
