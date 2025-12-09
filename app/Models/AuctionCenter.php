<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionCenter extends Model
{
    use HasFactory;

    protected $table = 'auction_center';

    protected $fillable = [
        'id',
        'name',
        'auction_platform_id',
    ];

    // Relationship with AuctionPlatform
    public function platform()
    {
        return $this->belongsTo(AuctionPlatform::class, 'auction_platform_id');
    }

    // Relationship with Auctions
    public function auctions()
    {
        return $this->hasMany(Auctions::class, 'center_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
