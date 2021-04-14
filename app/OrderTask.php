<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTask extends Model
{
	protected $table = 'order_tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_number',
        'task_display_id',
		'order_id',
		'task_type',
        'employer_id',
        'employee_id',
		'priority',
        'tat',
		'status',
        'received_date'
    ];
}