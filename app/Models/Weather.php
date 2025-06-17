<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = [
        'location',
        'temperature',
        'humidity',
        'rainfall',
        'condition',
        'date',
        'source',
    ];
}



