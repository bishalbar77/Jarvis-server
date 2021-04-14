<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
	protected $table = 'urls';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'url',
		'code',
		'hits',
		'valid_till'
    ];
}
