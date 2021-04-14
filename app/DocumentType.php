<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
	protected $table = 'document_types';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'documentName',
		'status',
		'source'
    ];
}
