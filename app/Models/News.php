<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    public function categories()
    {
        return $this->belongsToMany(NewsCategory::class,'news_category_pivots','news_id', 'category_id');
    }
}
