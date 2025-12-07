<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    
    protected $fillable = [
        'id',
        'name',
    ];
    protected $appends = ['count_access_product',];
    

    public function limit()
    {
        return $this->hasOne(MinLimitProduct::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getCountAccessProductAttribute()
    {
        $products = Product::where('status', true)->where('category_id', '=', $this->id)->where('city', 'kor')->get();
        if (empty($products)) {
            return 0;
        }
        return $products->count();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i:s j F Y');
    }
}
