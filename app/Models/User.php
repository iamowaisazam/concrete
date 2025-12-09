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

    public function pinnedNews()
    {
    return $this->belongsToMany(News::class, 'news_user_pins')->withTimestamps();
    }

    public function intrest()
    {
     return $this->hasMany(Interest::class,'user_id');
    }
    public function memberships()
    {
        return $this->hasMany(Membership::class, 'user_id', 'id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'user_type', 'id');
    }
    public function notificationSettings()
    {
        return $this->hasMany(UserNotificationSetting::class, 'user_id');
    }
    public function recentViews()
    {
        return $this->hasMany(RecentView::class);
    }


}
