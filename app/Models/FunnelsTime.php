<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunnelsTime extends Model
{
    public $table = 'funnels_time';
    public $timestamps = false;
    public $fillable = [
        'funell_id',
        'time',
        'text'
    ];
}
