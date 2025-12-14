<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{

    protected $table = 'products'; 
    protected $guarded = [];
    protected $appends = [
        'image_preview',
    ];


      protected function imagePreview(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ? asset('/uploads/'.$this->image) : null
        );
    }


     public function unit() {
        return $this->belongsTo(Unit::class, 'id');
    }

     public function category() {
        return $this->belongsTo(Category::class, 'id');
    }


    

 

   

    
}
