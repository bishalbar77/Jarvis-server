<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
	protected $table = 'task_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'task_type',
		'task_desc',
        'tat',
		'status'
    ];
}