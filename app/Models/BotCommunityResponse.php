<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BotCommunityResponse
 *
 * @property int $id
 * @property int $group_id
 * @property string $key
 * @property string $response
 * @property int $state
 * @property int $reserved
 * @property string $last_time_ckecked Время последнего изменения
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityResponse whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityResponse whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityResponse whereLastTimeCkecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityResponse whereReserved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityResponse whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityResponse whereState($value)
 * @mixin \Eloquent
 * @property-read \App\Models\UserGroups $group
 * @property string|null $action_id
 * @property int|null $add_group_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityResponse whereActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityResponse whereAddGroupId($value)
 */
class BotCommunityResponse extends Model
{
    public $table = 'bot_community_response';
    public $timestamps = false;
    public $fillable = [
        'group_id',
        'key',
        'scenario_name',
        'response',
        'state',
        'action_id',
        'add_group_id'
    ];

    public function group()
    {
        return $this->belongsTo(UserGroups::class, 'group_id', 'id');
    }

    public function timeList()
    {
        return $this->hasMany(BotCommunityTime::class, 'bot_community_response_id', 'id');
    }
}
