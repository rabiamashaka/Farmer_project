<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop',
        'location',
        'price_per_kg',
        'currency',
        'market_date',
        'source',
    ];
}
