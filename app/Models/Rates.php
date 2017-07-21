<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rates extends Model
{
    public    $timestamps = false;
    protected $table      = "rates";
    protected $fillable   = [
        'price',
        'days'
    ];
}
