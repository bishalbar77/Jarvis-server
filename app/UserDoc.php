<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDoc extends Model
{
	protected $table = 'user_docs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'user_id',
		'doc_type_id',
		'doc_number',
		'doc_url',
		'cosmos_id',
		'uploaded_by',
		'is_verified',
		'verified_by',
		'verification_date',
		'status',
    ];
}
