<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListRules extends Model
{
    protected $table = 'list_rules';
    protected $fillable = [
        'from',
        'to',
        'name',
        'client_group_id'
    ];

    public $timestamps = false;
}
