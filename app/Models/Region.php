<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'lat', 'lon'];

    /** Uhusiano: region ina *many* weather readings */
    public function weatherReadings()
    {
        return $this->hasMany(Weather::class);
    }
  

    public function farmers()
    {
        return $this->hasMany(Farmer::class);
    }
}


