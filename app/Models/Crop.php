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
}