<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Funnels
 *
 * @property int                                                                     $id
 * @property string                                                                  $name
 * @property int                                                                     $group_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FunnelsTime[] $times
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Funnels whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Funnels whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Funnels whereName($value)
 * @mixin \Eloquent
 */
class Funnels extends Model
{
    public $table      = 'funnels';
    public $timestamps = false;
    public $fillable   = [
        'name',
        'group_id',
        'client_group_id'
    ];

    public function times()
    {
        return $this->hasMany(FunnelsTime::class, 'funell_id', 'id')->orderBy('time', 'asc');
    }

    public function clientGroup()
    {
        return $this->hasOne(ClientGroups::class, 'id', 'client_group_id');
    }

    public function group()
    {
        return $this->belongsTo(UserGroups::class, 'id', 'group_id');
    }
}
