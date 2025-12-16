<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

     protected $table = 'payments';
    // protected $fillable = ['name'];
    protected $guarded = [];


    public function user() {
        return $this->belongsTo(User::class,'user_id');
    }
    
}
