<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserGroupsPivot
 *
 * @property int $id
 * @property int $user_id
 * @property int $usergroup_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroupsPivot whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroupsPivot whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroupsPivot whereUsergroupId($value)
 * @mixin \Eloquent
 */
class UserGroupsPivot extends Model
{
    public    $timestamps = false;
    public    $table      = 'user_groups_pivot';
    protected $fillable   = [
        'user_id',
        'usergroup_id'
    ];
}
