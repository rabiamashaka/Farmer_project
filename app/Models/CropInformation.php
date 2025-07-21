<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CropInformation extends Model
{
    protected $fillable = ['crop_id', 'type', 'title', 'description', 'image_path'];

    public function crop()
    {
        return $this->belongsTo(Crop::class);
    }
} 