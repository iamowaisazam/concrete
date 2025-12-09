<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = ['name'];




    public function autoBasics()
    {
        return $this->hasMany(AutoBasic::class, 'year_id');
    }

    public function vehicle()
    {
        return $this->hasMany(Vehicle::class, 'year_id');
    }




}
