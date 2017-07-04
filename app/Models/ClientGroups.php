<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientGroups extends Model
{
    public $table = 'client_groups';
    public $timestamps = false;
    public $fillable = [
        'group_id',
        'name',
        'auto_add_key'
    ];
}
