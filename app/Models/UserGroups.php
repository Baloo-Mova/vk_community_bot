<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserGroups
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string|null $avatar
 * @property int $group_id
 * @property int|null $expiries
 * @property string|null $token
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereExpiries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereUserId($value)
 * @mixin \Eloquent
 */
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

    public function user(){
        return $this->belongsTo(User::class);
    }
}
