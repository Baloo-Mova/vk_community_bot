<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FunnelsTime
 *
 * @property int $id
 * @property int $funell_id
 * @property int $time
 * @property string $text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FunnelsTime whereFunellId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FunnelsTime whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FunnelsTime whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FunnelsTime whereTime($value)
 * @mixin \Eloquent
 */
class FunnelsTime extends Model
{
    public $table = 'funnels_time';
    public $timestamps = false;
    public $fillable = [
        'funell_id',
        'time',
        'text'
    ];

    public function funnel(){
        return $this->belongsTo(Funnels::class, 'id', 'funell_id');
    }
}
