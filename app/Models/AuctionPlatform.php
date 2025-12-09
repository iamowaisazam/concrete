<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionPlatform extends Model
{
    protected $table = 'auction_platform';

    // protected $fillable = ['name'];
     protected $guarded = [];




public function centers()
{
    return $this->hasMany(AuctionCenter::class, 'auction_platform_id');
}


    



}
