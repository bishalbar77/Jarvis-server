<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'email_activation_code',
        'password',
        'api_token',
        'remember_token',
        'email_verified',
        'email_verified_at',
        'mobile',
        'country_code',
        'mobile_otp',
        'mobile_verified',
        'mobile_verified_at',
        'first_name',
        'middle_name',
        'last_name',
        'alias',
        'co_name',
        'dob',
        'gender',
        'address_id',
        'phone',
        'user_web_profile_id',
        'data_source_id',
        'last_seen',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at'  => 'datetime',
        'mobile_verified_at' => 'datetime',
    ];

    public function hasPermission($permission)
    {
        return  (bool) $this->permissions->where('name',$permission->name)->count();
    }
}
