<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
	protected $table = 'user_notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
		'type',
		'message',
		'is_view',
    ];
}
