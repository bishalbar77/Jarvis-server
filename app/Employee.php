<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	protected $table = 'employees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'employee_custom_id',
		'employee_type_id',
        'employee_code',
		'user_id',
		'doj',
		'employee_address_id',
		'is_compliant',
		'status'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function photo()
    {
        return $this->hasOne('App\UserPic', 'employee_id', 'id');
    }
}