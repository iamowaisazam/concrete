<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'color'; // or 'colors' if the table is plural
    // protected $fillable = ['name'];
    protected $guarded = [];
    public $timestamps = false;



    public function autoAdvance()
    {
    return $this->hasMany(AutoAdvance::class, 'color_id');
    }

    public function vehicle()
    {
    return $this->hasMany(Vehicle::class, 'color_id');
    }


}
