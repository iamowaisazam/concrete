<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{

     protected $table = 'unit';
    // protected $fillable = ['name'];
    protected $guarded = [];
     protected $appends = [
        'image_preview',
    ];

    
      protected function imagePreview(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->avatar ? asset('/uploads/'.$this->avatar) : null
        );
    }
    
}
