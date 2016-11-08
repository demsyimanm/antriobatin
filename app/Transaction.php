<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';
	protected $primaryKey = 'id';
	public $timestamps = true;
	public $incrementing = true;

	protected $fillable = array(
		'user_id',
		'doctor_id',
		'drugstore_id',
		'photo',
		'cost',
		'message',
		'duration',
		'status_id',
	);


	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function dokter()
	{
		return $this->belongsTo('App\User','doctor_id','id');
	}

	public function apotek()
	{
		return $this->belongsTo('App\User','drugstore_id','id');
	}


	public function status()
	{
		return $this->belongsTo('App\Status');
	}
}
