<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskTypeSeverity extends Model
{
	protected $table = 'task_type_severities';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'task_type_id',
		'task_severity',
		'severity_message_id'
    ];
}
