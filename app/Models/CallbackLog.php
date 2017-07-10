<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CallbackLog
 *
 * @property int $id
 * @property string $data
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CallbackLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CallbackLog extends Model
{
    protected $table = 'callback_log';
    protected $fillable = [
        'data'
    ];
}
