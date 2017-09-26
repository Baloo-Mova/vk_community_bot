<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotCommunityTime extends Model
{
    protected $table = 'bot_community_response_time';
    protected $fillable = [
        'from',
        'to',
        'name',
        'bot_community_response_id'
    ];

    public $timestamps = false;


}
