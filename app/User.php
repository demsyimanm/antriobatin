<?php 
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'password','name','telp', 'nip', 'barcode','address','role_id','token_fcm'];

    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    public function log()
    {
        return $this->hasMany('App\Role');
    }

    public function history()
    {
        return $this->hasMany('App\History');
    }

    public function history2()
    {
        return $this->hasMany('App\History','id','doctor_id');
    }

    public function transaction()
    {
        return $this->hasMany('App\Transaction');
    }

    public function transaction2()
    {
        return $this->hasMany('App\Transaction','id','doctor_id');
    }

    public function transaction3()
    {
        return $this->hasMany('App\Transaction','id','drugstore_uid');
    }
}
