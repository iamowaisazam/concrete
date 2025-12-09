<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoAdvance extends Model
{
    protected $table = 'auto_advance';

    protected $fillable = [
        'auction_id',
        'images',
        'vin_no',
        'color_id',
        'number_of_services_details',
        'last_service',
        'last_service_mileage',
        'dvsa_mileage',
        'grade',
        'inspection_date',
        'tyres_condition',
        'brakes',
        'hubs',
        'features',
        'equipment',
        'additional_information',
        'imported',
        'declarations',
    ];
}
