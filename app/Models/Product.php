<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'link',
        'price',
        'status',
        'category_id',
        'count_learn',
        'city',
        'thumbnail'
    ];
    protected $appends = ['isFavorite',];

    protected $casts = [
        'status' => 'boolean',
    ];
    public function getUpdatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i:s j F Y');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }
    public function getIsFavoriteAttribute()
    {
        $model = Favorite::where('product_id', '=', $this->id)->count();
        if ($model != 0) {
            return true;
        } else {
            return false;
        }
    }
}
