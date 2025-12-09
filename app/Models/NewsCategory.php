<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsCategory extends Model
{
    use HasFactory;
    protected $table = 'news_categories';
    protected $fillable = [
        'name',
    ];
    public $timestamps = true;
    
    public function News()
    {
        return $this->hasMany(News::class);
    }
}
