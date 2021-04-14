<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Act extends Model
{
	protected $table = 'acts';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'act_name',
		'act_no',
		'act_description',
		'status',
    ];
}
