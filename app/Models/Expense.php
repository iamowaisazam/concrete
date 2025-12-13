<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

     protected $table = 'expenses';
    // protected $fillable = ['name'];
    protected $guarded = [];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }
    
}
