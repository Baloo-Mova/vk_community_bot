<?php

namespace App\Models;

use App\Core\VK;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserGroups
 *
 * @property int                                                                              $id
 * @property int                                                                              $user_id
 * @property string                                                                           $name
 * @property string|null                                                                      $avatar
 * @property int                                                                              $group_id
 * @property int                                                                              $show_in_history
 * @property int|null                                                                         $expiries
 * @property string|null                                                                      $token
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereExpiries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereUserId($value)
 * @mixin \Eloquent
 * @property string|null                                                                      $last_time_checked
 * @property int                                                                              $status Включена или выключенна работа для группы
 * @property-read \App\Models\User                                                            $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereLastTimeChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereStatus($value)
 * @property string|null                                                                      $payed_for
 * @property string|null                                                                      $success_response
 * @property string|null                                                                      $secret_key
 * @property int                                                                              $payed
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BotCommunityResponse[] $activeTasks
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups wherePayed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups wherePayedFor($value)
 * @property int                                                                              $reserved
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ClientGroups[]         $clientGroups
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereReserved($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MassDelivery[]         $massDeliveries
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereSecretKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserGroups whereSuccessResponse($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Funnels[]              $funnels
 */
class UserGroups extends Model
{
    public    $timestamps = false;
    protected $table      = 'user_groups';
    protected $fillable   = [
        'user_id',
        'name',
        'avatar',
        'success_response',
        'group_id',
        'expiries',
        'token',
        'telegram_keyword',
        'show_in_history'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_groups_pivot', 'usergroup_id', 'user_id');
    }

    public function activeTasks()
    {
        return $this->hasMany(BotCommunityResponse::class, 'group_id',
            'id')->where(['bot_community_response.state' => 1]);
    }

    public function actions()
    {
        return $this->hasMany(BotCommunityResponse::class, 'group_id', 'id');
    }

    public function clientGroups()
    {
        return $this->hasMany(ClientGroups::class, 'group_id', 'id');
    }

    public function massDeliveries()
    {
        return $this->hasMany(MassDelivery::class, 'group_id', 'id');
    }

    public function funnels()
    {
        return $this->hasMany(Funnels::class, 'group_id', 'id');
    }

    public function moderatorLogs()
    {
        return $this->hasMany(ModeratorLogs::class, 'group_id', 'id');
    }

    public function checkAccess()
    {
        $vk = new VK();
        $vk->setGroup($this);

        return $vk->checkAccess();
    }

    public function removeControl()
    {
        $this->token            = null;
        $this->success_response = null;
        $this->secret_key       = null;
        $this->save();
    }

}
