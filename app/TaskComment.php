<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskComment extends Model
{
	protected $table = 'task_comments';

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
