<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
	protected $table = 'order_history';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'action',
		'order_id',
		'order_status',
		'action_by'
    ];

	public function verification()
	{
		return $this->belongsToMany('App\VerificationType', 'order_histories', 'id', 'verification_type');
	}
}
