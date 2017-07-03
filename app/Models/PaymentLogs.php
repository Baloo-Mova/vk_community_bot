<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentLogs extends Model
{

    const ReplenishmentBalance = 1; // пополение баланса

    public $timestamps = true;
    public $table = "payments_logs";

    public $fillable = [
        'user_id',
        'description',
        'payment_sum',
        'payment_number'
    ];
}
