<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;  // Ensure this is included
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable  // This should extend Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'companyName',
        'companyAddress1',
        'companyAddress2',
        'townCity',
        'country',
        'postcode',
        'telephone',
        'businessType',
        'companyReg',
        'website',
        'businessEmail',
        'motorTradeInsurance',
        'vatNumber',
        'firstName',
        'surname',
        'title',
        'jobTitle',
        'phone',
        'personalEmail',
        'password',
        'email_verification_token_status',
        'email_verification_token',
        'resend_count',
        'uploadID',
        'motorTradeProof',
        'addressProof',
        'avatar',
    ];

    protected $hidden = [
        'password',
    ];

  
 
    public function role()
    {
        return $this->belongsTo(Role::class, 'user_type', 'id');
    }




}
