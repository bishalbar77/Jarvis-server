<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
	protected $table = 'employers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employer_custom_id',
        'source_type',
        'user_id',
        'email',
        'email_activation_code',
        'email_verified',
        'email_verified_at',
        'b2b_company_name',
        'b2b_brand_name',
        'b2b_gst_no',
        'b2b_pan_no',
        'b2b_website',
        'phone',
        'country_code',
        'mobile',
        'billing_plan_id',
        'employer_type',
        'is_compliant',
        'status'
    ];

    public function user()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function photo()
    {
        return $this->hasOne('App\UserPic', 'employer_id', 'id');
    }
}