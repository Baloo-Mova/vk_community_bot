<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UserCache
 *
 * @property int $id
 * @property int $vk_id
 * @property string $fname
 * @property string $sname
 * @property string $photo
 * @property string $when_remove
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCache whereFname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCache whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCache wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCache whereSname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCache whereVkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserCache whereWhenRemove($value)
 * @mixin \Eloquent
 */
class UserCache extends Model
{
    protected $table = 'user_cache';
    public $timestamps = false;
    protected $fillable = [
        'fname',
        'sname',
        'vk_id',
        'photo',
        'when_remove'
    ];
}
