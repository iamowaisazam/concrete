<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlatefromAlert extends Model
{
    use HasFactory;

    protected $table = 'platefrom_alert'; // Table ka naam

    protected $fillable = [
        'user_id',
        'auction_id',
        'platform_id',
    ];

    /**
     * Relation with User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation with AuctionPlatform
     */
    public function platform()
    {
        return $this->belongsTo(AuctionPlatform::class, 'platefrom_id');
    }

    public function auction()
    {
        return $this->belongsTo(\App\Models\Auctions::class, 'auction_id');
    }


}
