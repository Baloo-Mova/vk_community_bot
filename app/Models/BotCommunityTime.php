<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BotCommunityTime
 *
 * @property int $id
 * @property string $name
 * @property string $from
 * @property string $to
 * @property int $bot_community_response_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityTime whereBotCommunityResponseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityTime whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityTime whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BotCommunityTime whereTo($value)
 * @mixin \Eloquent
 */
class BotCommunityTime extends Model
{
    protected $table = 'bot_community_response_time';
    protected $fillable = [
        'from',
        'to',
        'name',
        'bot_community_response_id'
    ];

    public $timestamps = false;


}
