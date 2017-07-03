<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotCommunityResponse extends Model
{
    public $table = 'bot_community_response';
    public $timestamps = false;
    public $fillable = [
        'group_id',
        'key',
        'response',
        'state',
        'reserved',
        'last_time_ckecked'
    ];
}
