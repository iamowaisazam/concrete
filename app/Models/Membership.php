<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{

    protected $guarded = [];

    // protected $fillable = [
    //     'user_id',
    //     'plan_id',
    //     'membership_start_date',
    //     'membership_expiry_date',
    //     'membership_status',
    //     'membership_type'
    // ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function plan() {
        return $this->belongsTo(Plan::class);
    }

    public function payment() {

        return $this->hasOne(MembershipPayment::class,'membership_id');
    }

}
