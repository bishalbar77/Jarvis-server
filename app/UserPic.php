<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPic extends Model
{
	protected $table = 'user_pics';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'employee_id',
		'employer_id',
		'photo_url',
		'is_verified',
		'uploaded_by'
    ];
}
