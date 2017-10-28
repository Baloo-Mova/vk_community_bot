<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ActionsInvoked
 *
 * @property int $id
 * @property int $count
 * @property int $bot_community_response_id
 * @property string $key
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActionsInvoked whereBotCommunityResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActionsInvoked whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActionsInvoked whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ActionsInvoked whereKey($value)
 * @mixin \Eloquent
 */
class ActionsInvoked extends Model
{
    protected $table = 'actions_invoked';
    public $timestamps = false;
    protected $fillable = [
        'count',
        'key',
        'bot_community_response_id'
    ];
}
