<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentView extends Model
{
    use HasFactory;

    protected $table = 'recent_views';

    protected $fillable = [
        'user_id',
        'vehicle_id',
    ];

    /**
     * RecentView belongs to User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * RecentView belongs to Vehicle
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }
}
