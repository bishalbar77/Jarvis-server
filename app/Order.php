<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number',
        'order_display_ids',
		'order_dispaly_desc',
		'status',
		'priority',
        'tat',
        'employer_id',
		'employee_id',
        'received_date'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}