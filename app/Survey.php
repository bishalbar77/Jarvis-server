<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'surveys';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'survey_type',
		'employee_id',
		'employer_id',
		'survey_start',
		'survey_end',
		'severity',
		'survey_status'
    ];
}
