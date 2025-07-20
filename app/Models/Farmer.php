<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

  protected $fillable = [
    'user_id',
    'name',
    'phone',
    'region_id',
    'farming_type',
];

public function region()
{
    return $this->belongsTo(Region::class);
}

public function crops()
{
    return $this->belongsToMany(Crop::class);
}

}
