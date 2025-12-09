<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{

    protected $table = 'vehicles';
    protected $guarded = []; // allow mass assignment on all columns

    // protected $fillable = [
    //     'auction_id',
    //     'title',
    //     'vehicle_type_id',
    //     'make_id',
    //     'model_id',
    //     'variant_id',
    //     'body_type_id',
    //     'year_id',
    //     'doors',
    //     'seats',
    //     'fuel_type',
    //     'transmission',
    //     'cc',
    //     'keys',
    //     'euro_status',
    //     'mileage',
    //     'engine_runs',
    // ];



    public function auction()
    {
        return $this->belongsTo(Auctions::class, 'auction_id', 'id');
    }

    

    public function autoAdvance()

    {
        return $this->hasOne(AutoAdvance::class, 'auction_id' , 'auction_id');
    }

    public function autoLegal()
    {
        return $this->hasOne(AutoLegal::class, 'auction_id' , 'auction_id');
    }

    public function autoPrice()
    {
        return $this->hasOne(AutoPrice::class, 'auction_id', 'auction_id');
    }
    
    public function make()
    {
        return $this->belongsTo(Make::class, 'make_id');
    }
    public function vehicle_type()
    {
        return $this->belongsTo(VehicleType::class, 'vehicle_id');
    }
    public function body_types()
    {
        return $this->belongsTo(BodyType::class, 'body_id');
    }
    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function model()
    {
        return $this->belongsTo(VehicleModel::class, 'model_id');
    }

    public function getImage()
    { 
        if($this->images){
            if (is_array(explode(',',$this->images))) {

                return explode(',',$this->images)[0];
            }
        }
        
        return '';
    }

     public function getImages()
    { 
        if($this->images){
            if (is_array(explode(',',$this->images))) {
                return explode(',',$this->images);
            }
        }
        return [];
    }

    public function variant()
    {
        return $this->belongsTo(ModelVariant::class, 'variant_id');
    }

    public function year()
    {
        return $this->belongsTo(Year::class, 'year_id');
    }

    public function previousAuction()
    {

        $id = $this->id;
        $reg = $this->reg;

        return Vehicle::whereNot('id',$id)->orderBy('start_date')->where('reg',$reg)->first();

    }





}

