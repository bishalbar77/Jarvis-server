<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VerificationFields extends Model
{
	protected $table = 'verification_fields';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'verification_type_id',
		'fields_name',
		'fields_type',
        'option_value',
        'isRequired',
		'status'
    ];

    public function verificationtype()
    {
        return $this->belongsTo(VerificationType::class);
    }
}
