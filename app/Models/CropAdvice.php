<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CropAdvice extends Model
{
    protected $table = 'crop_advices';  // explicitly define plural table name

    protected $fillable = ['crop_id', 'type', 'title', 'description'];
}
