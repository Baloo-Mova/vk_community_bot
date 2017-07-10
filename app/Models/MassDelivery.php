<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\MassDelivery
 *
 * @mixin \Eloquent
 * @property int                 $id
 * @property int                 $group_id
 * @property string              $rules
 * @property string              $message
 * @property int                 $reserved
 * @property int                 $sended
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MassDelivery whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MassDelivery whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MassDelivery whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MassDelivery whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MassDelivery whereReserved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MassDelivery whereRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MassDelivery whereSended($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MassDelivery whereUpdatedAt($value)
 * @property string $when_send
 * @property-read \App\Models\UserGroups $group
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MassDelivery whereWhenSend($value)
 */
class MassDelivery extends Model
{
    public    $timestamps = true;
    public    $fillable   = [
        'group_id',
        'rules',
        'message',
        'reserved',
        'sended',
        'when_send'
    ];
    protected $table      = 'mass_delivery';

    public function group(){
        return $this->belongsTo(UserGroups::class,'group_id','id');
    }
}
