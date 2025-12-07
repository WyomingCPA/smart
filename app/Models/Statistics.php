<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
class Statistics extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_all_product',
        'total_favorite_product',
        'count_all_research_product',
        'count_available_product',
    ];
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('H:i:s j F Y');
    }
}
