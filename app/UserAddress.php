<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $table = 'user_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'employee_id',
		'employer_id',
		'type',
		'street_addr1',
		'street_addr2',
		'village',
		'post_office',
		'police_station',
		'district',
		'near_by',
		'city',
		'state',
		'pincode',
		'country',
		'stayed_from',
		'stayed_to',
		'is_verified',
		'verified_by'
    ];
}
