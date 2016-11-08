<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
	protected $primaryKey = 'id';
	public $timestamps = true;
	public $incrementing = true;

	protected $fillable = array(
		'name',
	);

	public function transaction()
	{
		return $this->hasMany('App\Transaction');
	}
}
