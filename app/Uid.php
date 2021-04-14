<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Uid extends Eloquent
{
	protected $connection = 'mongodb';
	protected $collection = 'uids';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uid_type', 
        'uid_number', 
        'uid_data'
    ];
}
