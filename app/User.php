<?php
 
namespace App;

use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\RoleUsers;
use App\Role;
use Phoenix\EloquentMeta\MetaTrait;

class User extends Model implements AuthenticatableContract , CanResetPasswordContract {

    use Authenticatable ,
        CanResetPassword ,
        ShinobiTrait;

use MetaTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [ 'name' , 'email' , 'password' ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [ 'password' , 'remember_token' ];

    public function getUser() {
        //return $this->hasOne( 'App\RoleUsers' );
    }

}
