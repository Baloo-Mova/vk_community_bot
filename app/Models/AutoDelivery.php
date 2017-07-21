<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AutoDelivery
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $vk_id
 * @property int $client_group_id
 * @property int $group_id
 * @property string $message
 * @property int $when_send
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AutoDelivery whereClientGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AutoDelivery whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AutoDelivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AutoDelivery whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AutoDelivery whereVkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AutoDelivery whereWhenSend($value)
 */
class AutoDelivery extends Model
{
    public $table="auto_delivery";
    public $timestamps  = false;
    public $fillable = [
        'vk_id',
        'client_group_id',
        'group_id',
        'message',
        'when_send'
    ];

    public function group(){
        return $this->belongsTo(UserGroups::class,'group_id','id');
    }


}
