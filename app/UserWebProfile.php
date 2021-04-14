<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWebProfile extends Model
{
    protected $table = 'user_web_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'fb_id',
		'fb_connection_id',
		'li_id',
		'li_connection_id',
		'twtr_id',
		'twtr_connection_id',
		'other_ids'
    ];
}
