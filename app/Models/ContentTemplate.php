<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentTemplate extends Model
{
    protected $fillable = [
        'title', 'category', 'language', 'content',
        'regions', 'crops', 'status', 'parent_id',
    ];

    protected $casts = [
        'regions' => 'array',
        'crops'   => 'array',
    ];

    // scopePublished() kwa urahisi
    public function scopePublished($q) { return $q->where('status', 'published'); }
}
