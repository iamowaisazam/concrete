<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Make extends Model
{

    protected $table = 'make'; 

    // protected $fillable = ['name'];
     protected $guarded = [];

    public function models()
    {
        return $this->hasMany(VehicleModel::class);
    }

    public function autoBasics()
    {
        return $this->hasMany(AutoBasic::class, 'make_id');
    }

     public function vehicle()
    {
        return $this->hasMany(Vehicle::class, 'make_id');
    }
    
}
