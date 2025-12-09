<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelVariant extends Model
{
    protected $table = 'model_variant';

    // protected $fillable = ['name', 'model_id'];
      protected $guarded = [];

    public function model()
    {
        return $this->belongsTo(VehicleModel::class, 'model_id');
    }

    public function autoBasics()
    {
        return $this->hasMany(AutoBasic::class, 'variant_id');
    }

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class, 'variant_id');
    }

    


}
