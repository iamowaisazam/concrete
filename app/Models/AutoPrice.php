<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoPrice extends Model
{
    protected $table = 'auto_price';

    protected $fillable = [
        'auction_id',
        'bidding_history',
        'last_bid',
        'bidding_status',
        'cap_new',
        'cap_retail',
        'cap_clean',
        'cap_average',
        'cap_below',
        'glass_new',
        'glass_retail',
        'glass_trade',
        'autotrader_retail_value',
        'autotrader_trade_value',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'lot_no',
    ];

    public $timestamps = true;
}

