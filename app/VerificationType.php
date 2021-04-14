<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerificationType extends Model
{
	protected $table = 'verification_types';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'name',
		'internal_name',
		'amount',
		'icon_url',
		'description',
		'source',
		'status',
		'tat',
		'order_type',
		'task_type'
    ];
}
