<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'image', 'description', 'date', 'author_id',
        'category_id', 'tag', 'meta_title', 'meta_description',
        'meta_keyword', 'slug', 'status'
    ];

    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category() {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
}
