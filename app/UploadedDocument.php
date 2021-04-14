<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadedDocument extends Model
{
	protected $table = 'uploaded_documents';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'filesName',
		'worker_id',
		'company_id',
		'docTypeId',
		'docNumber',
		'status',
		'orderId',
    ];
}
