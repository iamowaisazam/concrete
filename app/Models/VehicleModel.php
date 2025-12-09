<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    protected $table = 'model'; // explicitly define because "models" is a reserved keyword in Laravel

    // protected $fillable = ['name', 'make_id'];
      protected $guarded = [];

    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    public function variants()
    {
        return $this->hasMany(ModelVariant::class, 'model_id');
    }

    public function autoBasics()
    {
    return $this->hasMany(AutoBasic::class, 'model_id');
    }

    public function vehicle()
    {
    return $this->hasMany(Vehicle::class, 'model_id');
    }


    
}
