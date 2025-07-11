<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
     protected $fillable = [
        'campaign_id', 'phone', 'message', 'direction', 'status', 'sent_at',
    ];
}
