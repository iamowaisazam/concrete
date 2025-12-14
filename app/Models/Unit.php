<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{

     protected $table = 'unit';
    // protected $fillable = ['name'];
    protected $guarded = [];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
    
}
