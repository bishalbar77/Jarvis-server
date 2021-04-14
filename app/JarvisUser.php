<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JarvisUser extends Model
{
	protected $table = 'jarvis_users';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'user_id',
		'is_super_admin',
		'source',
		'status',
    ];
}
