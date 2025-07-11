<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'location',
        'farming_type',
        'region_id',     // MUHIMU: ruhusu mass‑assignment
    ];

    /*--------------------------------------------------
    | Relationships
    *-------------------------------------------------*/
    public function crops()
    {
        return $this->belongsToMany(Crop::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
