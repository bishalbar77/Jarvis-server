<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    protected $table = 'api_keys';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'api_key',
		'api_system_name',
		'created_by',
		'verified_by',
		'status'
    ];
}
