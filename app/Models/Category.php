<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class Category extends Model
{

     protected $table = 'category';
    // protected $fillable = ['name'];
    protected $guarded = [];
    protected $appends = [
        'image_preview',
    ];

 

      protected function imagePreview(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->image ?  asset('/uploads/'.$this->image) : null
        );
    }
    
}
