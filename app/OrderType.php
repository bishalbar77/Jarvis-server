<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
	protected $table = 'order_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'order_type',
		'order_desc',
		'task_deps',
        'tat',
		'status',
		'created_by'
    ];
}