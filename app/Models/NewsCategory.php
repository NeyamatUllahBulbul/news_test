<?php

namespace App\Models;

use App\Models\Scopes\FetchDataByUserTerritory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class NewsCategory extends Model
{
    use HasFactory;

    const STATUS_ACTIVE   = 1;
    const STATUS_INACTIVE = 0;

    const STATUS_LIST = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];


    public function news()
    {
        return $this->belongsToMany(News::class,'news_category_pivots','category_id', 'news_id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($category) {
            $category->news()->delete();
        });
    }
}
