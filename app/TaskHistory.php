<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskHistory extends Model
{
	protected $table = 'task_history';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'action',
		'task_id',
        'task_status',
        'action_by',
        'candidate_data',
        'antecedants_data',
        'report_url',
        'verification_status',
        'verification_comment',
        'verification_date',
		'verified_by',
    ];
}
