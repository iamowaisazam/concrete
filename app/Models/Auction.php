<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    // Define the table name if it doesn't follow Laravel's default plural naming convention
    protected $table = 'auction';

    // Define the fillable fields for mass assignment
    protected $fillable = [
        'Reg_No',
        'Lot_num',
        'Title',
        'Mileage',
        'Featured_in',
        'Confirmed',
        'Date_venue',
        'Auction_name',
        'Vehicle_Location',
        'lots',
        'Images',
        'Vehicle_Type',
        'Colour',
        'Fuel',
        'Transmission',
        'No_of_doors',
        'CO2_Emissions',
        'NOX_Emissions',
        'No_of_keys',
        'Log_book',
        'No_of_owners',
        'Date_of_registration',
        'VAT_Type',
        'Service_History',
        'Number_of_services',
        'Last_Service',
        'Last_service_mileage',
        'DVSA_mileage',
        'Additional_service_notes',
        'MOT_Expiry',
        'Declarations',
        'Additional',
        'Equipment',
        'Grade',
        'Condition_Report_text',
        'Condition_report',
        'CAP_HPI',
        'Glass\'s',
        'Pricing_text',
        'Other_rep_title',
        'Other_rep_detail',
        'Other_rep_link'
    ];

    // Optionally, you can define the date columns for automatic conversion
    protected $dates = [
        'Date_venue',
        'Date_of_registration',
        'Last_Service',
        'MOT_Expiry',
    ];


}
