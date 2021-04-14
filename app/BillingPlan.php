<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingPlan extends Model
{
    protected $table = 'billing_plans';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'code',
		'name',
		'description',
		'billing_verification_tasks',
		'amount',
		'status'
    ];
}