<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPref extends Model
{
	protected $table = 'user_prefs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
		'employee_id',
		'employer_id',
		'lang',
		'locale',
		'date_pattern',
		'time_format',
		'time_zone',
		'notify_by_sms',
		'notify_by_email',
		'notify_by_wa'
    ];
}
