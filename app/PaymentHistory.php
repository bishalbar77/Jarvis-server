<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model
{
	protected $table = 'payment_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'worker_id',
		'company_id',
		'additional_amount',
		'additional_amount_status',
		'payment_request_id',
		'temp_id',
		'discount',
		'promocode',
		'gst',
		'subTotal',
    ];

	public function employer()
	{
		return $this->belongsToMany('App\Employer', 'payment_histories', 'id', 'company_id');
	}

	public function employees()
	{
		return $this->belongsToMany('App\Employee', 'payment_histories', 'id', 'worker_id');
	}
}
