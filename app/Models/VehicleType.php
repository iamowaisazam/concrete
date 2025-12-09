<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    protected $table = 'vehicle_type'; // explicitly define the table name if it's not plural

    // protected $fillable = [
    //     'name',
    // ];
    protected $guarded = [];

    public $timestamps = false; // assuming your table has no created_at / updated_at



    public function autoBasics()
{
    return $this->hasMany(AutoBasic::class, 'vehicle_id');
}

 public function vehicle()
{
    return $this->hasMany(Vehicle::class, 'vehicle_id');
}





}



