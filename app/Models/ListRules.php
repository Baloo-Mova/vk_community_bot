<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ListRules
 *
 * @property int $id
 * @property string $name
 * @property string $from
 * @property string $to
 * @property int $client_group_id
 * @property int $group_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ListRules whereClientGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ListRules whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ListRules whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ListRules whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ListRules whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ListRules whereTo($value)
 * @mixin \Eloquent
 */
class ListRules extends Model
{
    protected $table = 'list_rules';
    protected $fillable = [
        'from',
        'to',
        'name',
        'client_group_id',
        'group_id'
    ];

    public $timestamps = false;
}
