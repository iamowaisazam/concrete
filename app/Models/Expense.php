<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

     protected $table = 'expenses';
    // protected $fillable = ['name'];
    protected $guarded = [];


    public function category() {
        return $this->belongsTo(ExpenseCategory::class, 'id');
    }
    
}
