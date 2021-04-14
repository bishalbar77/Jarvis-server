<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class B2bUser extends Model
{
	protected $table = 'b2b_users';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id',
		'email',
		'password',
		'status',
    ];
}
