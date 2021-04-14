<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataSource extends Model
{
	protected $table = 'data_sources';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'source_name',
		'campaign_name',
		'ip_address'
    ];
}
