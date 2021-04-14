<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployerEmployeeNetwork extends Model
{
    protected $table = 'employer_employee_network';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'employer_id',
      'its_employee',
      'status'
    ];
}
