<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class UserModel extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
	use Authenticatable, Authorizable, CanResetPassword;
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_username', 'user_password', 'user_fullname', 'user_group_id'];
    //const CREATED_AT = 'user_created_at';
    //const UPDATED_AT = 'user_updated_at';
    //const DELETED_AT = 'user_deleted_at';


    public function getAuthPassword()
	{
	    return $this->user_password;
	}
}
