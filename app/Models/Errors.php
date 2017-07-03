<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Errors
 *
 * @property int $id
 * @property string $text
 * @property string|null $url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Errors whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Errors whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Errors whereUrl($value)
 * @mixin \Eloquent
 */
class Errors extends Model
{
    public    $timestamps = false;
    protected $table      = 'errors';
    protected $fillable   = [
        'text',
        'url'
    ];
}
