<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Weather extends Model
{
    use HasFactory;

    protected $table = 'weather_readings';

    // ongeza kila column iliyo kwenye jedwali
   // app/Models/Weather.php
protected $fillable = [
    'region_id',
    'temperature',
    'humidity',
    'wind',
    'rain',
    'condition',   // <= mpya
    'source',      // <= mpya
    'measured_at',
];


    protected $casts = [
        'measured_at' => 'datetime',
    ];

    /* ----------------------------------
     |  UHUSIANO NA MKOA (regions table)
     |----------------------------------*/
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    /* ----------------------------------
     |  ACCESSORS (majina ambayo view inategemea)
     |----------------------------------*/

    // Location – litapokea jina la mkoa
    public function getLocationAttribute(): ?string
    {
        return optional($this->region)->name;
    }

    // Rainfall (mm)
    public function getRainfallAttribute(): ?float
    {
        return $this->attributes['rain'];   // ‘rain’ kwenye db
    }

    // Date – format unavyopenda
    public function getDateAttribute(): string
    {
        return $this->measured_at
               ? $this->measured_at->format('Y-m-d H:i')
               : '-';
    }

    // Source – default kama haijatajwa
    public function getSourceAttribute(): string
    {
        return $this->attributes['source'] ?? 'OpenWeather';
    }
}
