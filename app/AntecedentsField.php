<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AntecedentsField extends Model
{
	protected $table = 'antecedents_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'order_history_id',
		'verification_field_id',
        'antecedents_value',
        'match_status',
		'user_id'
    ];
}