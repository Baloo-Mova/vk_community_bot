<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ModeratorLogs
 *
 * @property int $id
 * @property int $group_id
 * @property int|null $action_id
 * @property string $event_id
 * @property int $vk_id
 * @property string|null $name
 * @property string|null $date
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModeratorLogs whereActionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModeratorLogs whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModeratorLogs whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModeratorLogs whereEventId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModeratorLogs whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModeratorLogs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModeratorLogs whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModeratorLogs whereVkId($value)
 * @mixin \Eloquent
 */
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
