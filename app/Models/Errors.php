<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Errors extends Model
{
    public    $timestamps = false;
    protected $table      = 'errors';
    protected $fillable   = [
        'text',
        'url'
    ];
}
