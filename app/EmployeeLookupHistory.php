<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeLookupHistory extends Model
{
    protected $table = 'employee_lookup_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'employee_id',
		'doc_type_id',
		'latitude',
		'longitude',
		'ip_address',
		'browser_info',
		'lookup_by',
		'status'
    ];
}
