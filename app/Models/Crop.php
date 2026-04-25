<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    protected $fillable = ['name'];

    public function farmers()
    {
        return $this->belongsToMany(Farmer::class);
    }

    public function information()
    {
        return $this->hasMany(\App\Models\CropInformation::class);
    }

    public function advices()
    {
        return $this->hasMany(\App\Models\CropAdvice::class);
    }

    public function marketPrices()
    {
        return $this->hasMany(\App\Models\MarketPrice::class);
    }

    public function diseases()
    {
        return $this->hasMany(\App\Models\CropDisease::class);
    }
}