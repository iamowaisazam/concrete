<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
protected $fillable = [
    'user_id',
    'ip_address',
    'device',
    'platform',
    'browser',
    'user_agent',
    'location',
    'country',
    'country_code',
    'region',
    'region_name',
    'city',
    'zip',
    'lat',
    'lon',
    'timezone',
    'isp',
    'org',
    'as_info',
    'logged_in_at',
];

}

