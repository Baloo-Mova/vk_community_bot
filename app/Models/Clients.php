<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    public $table = 'clients';
    public $timestamps = false;
    public $fillable = [
        'client_group_id',
        'vk_id'
    ];
}
