<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    protected $table = 'employee_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'description',
        'source',
        'status'
    ];
}
