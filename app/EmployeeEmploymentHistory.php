<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeEmploymentHistory extends Model
{
    protected $table = 'employee_employment_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'employee_id',
		'employed_by',
		'salary',
		'employment_start',
		'employment_stop',
		'is_verified',
		'verified_by',
		'verification_date'
    ];
}
