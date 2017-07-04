<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ClientGroups
 *
 * @property int $id
 * @property string $group_id
 * @property string $name
 * @property string $auto_add_key
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientGroups whereAutoAddKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientGroups whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientGroups whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ClientGroups whereName($value)
 * @mixin \Eloquent
 */
class ClientGroups extends Model
{
    public $table = 'client_groups';
    public $timestamps = false;
    public $fillable = [
        'group_id',
        'name',
        'auto_add_key'
    ];
}
