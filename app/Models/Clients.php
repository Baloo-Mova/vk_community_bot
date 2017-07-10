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
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $avatar
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Clients whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Clients whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Clients whereLastName($value)
 */
class Clients extends Model
{
    public $table = 'clients';
    public $timestamps = false;
    public $fillable = [
        'client_group_id',
        'vk_id',
        'first_name',
        'last_name',
        'avatar'
    ];
}
