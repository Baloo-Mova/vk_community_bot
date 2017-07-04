<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserGroups
 *
 * @property int                   $id
 * @property int                   $user_id
 * @property string                $name
 * @property string|null           $avatar
 * @property int                   $group_id
 * @property int|null              $expiries
 * @property string|null           $token
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereExpiries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereUserId($value)
 * @mixin \Eloquent
 * @property string|null           $last_time_checked
 * @property int                   $status Включена или выключенна работа для группы
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereLastTimeChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereStatus($value)
 * @property string|null $payed_for
 * @property int $payed
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BotCommunityResponse[] $activeTasks
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups wherePayed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups wherePayedFor($value)
 */
class UserGroups extends Model
{
    public    $timestamps = false;
    protected $table      = 'user_groups';
    protected $fillable   = [
        'user_id',
        'name',
        'avatar',
        'group_id',
        'expiries',
        'token'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function activeTasks()
    {
        return $this->hasMany(BotCommunityResponse::class, 'group_id', 'id')->where(['bot_community_response.state' => 1]);
    }

    public function clientGroups()
    {
        return $this->hasMany(ClientGroups::class, 'group_id', 'id');
    }
}
