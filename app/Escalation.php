<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Escalation extends Model
{
	protected $table = 'escalations';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'order_history_task_id',
		'escalate_to',
		'message',
		'user_id',
    ];
}
