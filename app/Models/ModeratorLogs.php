<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModeratorLogs extends Model
{
    public    $timestamps = false;
    public    $fillable   = [
        'group_id',
        'action_id',
        'event_id',
        'name',
        'date',
        'description'
    ];
    protected $table      = 'moderator_logs';

}
