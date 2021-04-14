<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyNotifications extends Model
{
	protected $table = 'company_notifications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
		'worker_id',
		'notification',
		'status',
    ];
}
