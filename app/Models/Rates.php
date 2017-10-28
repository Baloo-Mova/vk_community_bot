<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Rates
 *
 * @property int $id
 * @property int $price
 * @property int $days
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rates whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rates whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rates whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Rates wherePrice($value)
 * @mixin \Eloquent
 */
class Rates extends Model
{
    public    $timestamps = false;
    protected $table      = "rates";
    protected $fillable   = [
        'price',
        'days'
    ];
}
