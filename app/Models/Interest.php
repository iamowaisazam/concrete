<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $table = 'interest';

    // protected $fillable = [
    //     'user_id', 'title', 'make_id', 'model_id', 'year_from', 'year_to',
    //     'transmission', 'model_variant_id', 'engine_size_min', 'engine_size_max',
    //     'mileage_max', 'auction_house_id', 'auction_grade_condition',
    //     'previous_owners_max', 'body_type_id', 'no_of_service_max',
    //     'estimated_retail_value_min', 'estimated_retail_value_max'
    // ];

    protected $guarded = [];

    // protected $casts = [
    //     'engine_size_min' => 'float',
    //     'engine_size_max' => 'float',
    //     'mileage_max' => 'integer',
    //     'previous_owners_max' => 'integer',
    //     'no_of_service_max' => 'integer',
    //     'estimated_retail_value_min' => 'float',
    //     'estimated_retail_value_max' => 'float',
    // ];

    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    public function model()
    {
        return $this->belongsTo(VehicleModel::class);
    }

    public function modelVariant()
    {
        return $this->belongsTo(ModelVariant::class);
    }

      public function variant()
    {
        return $this->belongsTo(ModelVariant::class, 'variant_id');
    }

    public function bodyType()
    {
        return $this->belongsTo(BodyType::class);
    }

    public function auctionHouse()
    {
        return $this->belongsTo(AuctionPlatform::class, 'auction_house_id');
    }

    public function platform()
    {
        return $this->belongsTo(AuctionPlatform::class, 'platform_id');
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
