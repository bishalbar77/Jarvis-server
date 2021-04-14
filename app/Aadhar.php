<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Aadhar extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'aadhars';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'aadhar_number', 
        'aadhar_details'
    ];
}
