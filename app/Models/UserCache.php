<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCache extends Model
{
    protected $table = 'user_cache';
    public $timestamps = false;
    protected $fillable = [
        'fname',
        'sname',
        'vk_id',
        'photo',
        'when_remove'
    ];
}
