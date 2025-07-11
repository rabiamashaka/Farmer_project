<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsCampaign extends Model
{ protected $fillable = [
        'title',
        'message',
        'locations',  // if you use these as mass assignable
        'crops',
        'language',
        'status',
        'sent',
    ];

    protected $casts = [
        'locations' => 'array',
        'crops'     => 'array',
    ];
}
