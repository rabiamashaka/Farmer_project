<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CropDisease extends Model
{
    protected $table = 'crop_diseases';
    
    protected $fillable = [
        'crop_id',
        'name',
        'description'
    ];

    // Relationship to Crop
    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
}
