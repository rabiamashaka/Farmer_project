<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'crop_id',
        'region_id',
        'price_per_kg',
        'currency',
        'market_date',
        'source',
    ];

    // Relationship to Region
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    // Relationship to Crop (if you have it)
    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
