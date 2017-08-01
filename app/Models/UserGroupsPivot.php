<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroupsPivot extends Model
{
    public    $timestamps = false;
    public    $table      = 'user_groups_pivot';
    protected $fillable   = [
        'user_id',
        'usergroup_id'
    ];
}
