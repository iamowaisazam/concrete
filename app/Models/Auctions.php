<?php

// app/Models/Auction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auctions extends Model
{
    protected $fillable = [
        'name',
        'table_id',
        'auction_date',
        'end_date',
        'auction_type',
        'platform_id',
        'status',
        'csv_path'
    ];

    public function platform()
    {
        return $this->belongsTo(AuctionPlatform::class);
    }

    public function center()
    {
        return $this->belongsTo(AuctionCenter::class);
    }
    

public function autoBasics() {
    return $this->hasMany(AutoBasic::class, 'auction_id');
}

public function autoPrices() {
    return $this->hasMany(AutoPrice::class, 'auction_id');
}


public function autoLegals() {
    return $this->hasMany(AutoLegal::class, 'auction_id');
}

public function autoAdvances() {
    return $this->hasMany(AutoAdvance::class, 'auction_id');
}




}
