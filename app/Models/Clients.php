<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Clients
 *
 * @property int $id
 * @property int $client_group_id
 * @property int $vk_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Clients whereClientGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Clients whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Clients whereVkId($value)
 * @mixin \Eloquent
 */
class Clients extends Model
{
    public $table = 'clients';
    public $timestamps = false;
    public $fillable = [
        'client_group_id',
        'vk_id'
    ];
}
