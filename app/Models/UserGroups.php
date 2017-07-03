<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroups extends Model
{
    public $timestamps = false;
    protected $table = 'user_groups';
    protected $fillable = [
        'user_id',
        'name',
        'avatar',
        'group_id',
        'expiries',
        'token'
    ];

}
