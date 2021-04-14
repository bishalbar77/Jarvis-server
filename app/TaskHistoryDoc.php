<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskHistoryDoc extends Model
{
	protected $table = 'task_history_docs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_history_id',
        'document_url',
		'document_name'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}