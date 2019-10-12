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
use Illuminate\Notifications\Notifiable;

class UserModel extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
	use Authenticatable, Authorizable, CanResetPassword, Notifiable, SoftDeletes;
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $fillable = ['user_username', 'user_password', 'user_fullname', 'user_group_id', 'created_at', 'update_at', 'deleted_at'];

    public function getAuthPassword()
	{
	    return $this->user_password;
	}
}
