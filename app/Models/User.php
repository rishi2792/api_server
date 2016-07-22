<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use DB;
use \Exception;

class User extends Model implements AuthenticatableContract,AuthorizableContract,CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;


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
    protected $fillable = [
        'name', 'email', 'password','login_detail','last_seen','social_link','address','phone','wishberry_awareness',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function groups()
    {
        return $this->belongsToMany('App\Models\User\Group', 'users_groups', 'user_id', 'group_id')->withTimestamps();
    }

    public function social()
    {
        return $this->hasMany('App\Models\User\Social','user_id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image\Image', 'imageable');
    }

    public function people()
    {
        return $this->morphOne('App\Models\Person\Person', 'personable');
    }

    public function campaigns(){

        return $this->belongsToMany('App\Models\campaign','campaigns_users','user_id','campaign_id')->withPivot('role')->withTimestamps();
    }

    public function messages(){
        return $this->hasMany('App\Models\user_message','user_id');
    }

    public function transactions(){
        return $this->hasMany('App\Models\transaction','user_id');
    }


    
}
