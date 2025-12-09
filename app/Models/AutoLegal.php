<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoLegal extends Model
{
    protected $table = 'auto_legal';

    protected $fillable = [
        'auction_id',
        'dor',
        'reg',
        'former_keepers',
        'mileage_warranted',
        'mot_expiry_date',
        'mot_due',
        'v5',
        'vat_status',
        'service_history',
        'number_of_services',
        'number_of_stamps',
        'inspection_report',
        'other_report_name',
        'other_report',
        'service_note',
        'vendor',
    ];
}

