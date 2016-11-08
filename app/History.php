<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $table = 'history';
	protected $primaryKey = 'id';
	public $timestamps = true;
	public $incrementing = true;

	protected $fillable = array(
		'user_id',
		'illness',
		'year',
		'doctor_id',
		'description'
	);


	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function dokter()
	{
		return $this->belongsTo('App\User','doctor_id','id');
	}
}
