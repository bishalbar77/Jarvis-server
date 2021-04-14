<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeverityMessage extends Model
{
	protected $table = 'severity_messages';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'severity_message',
        'status'
    ];
}
