<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funnels extends Model
{
    public $table = 'funnels';
    public $timestamps = false;
    public $fillable = [
        'name',
        'group_id',
    ];

    public function times()
    {
        return $this->hasMany(FunnelsTime::class, 'funell_id', 'id')->orderBy('id', 'desc');
    }

}
