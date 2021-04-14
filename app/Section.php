<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
	protected $table = 'sections';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'act_id',
		'section_details',
		'status'
    ];
}
