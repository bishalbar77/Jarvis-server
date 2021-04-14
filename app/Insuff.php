<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Insuff extends Model
{
	protected $table = 'insuffs';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'order_history_task_id',
		'message',
		'user_id',
    ];
}
