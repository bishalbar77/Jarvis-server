<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionSummary extends Model
{
	protected $table = 'action_summaries';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_history_task_id',
		'type',
		'message',
		'user_id',
    ];
}
