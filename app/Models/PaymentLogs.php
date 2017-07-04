<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PaymentLogs
 *
 * @property int $id
 * @property int $user_id
 * @property int $description Описание действия
 * @property string $payment_sum
 * @property string|null $invoice_id
 * @property int $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentLogs whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentLogs whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentLogs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentLogs whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentLogs wherePaymentSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentLogs whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentLogs whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentLogs whereUserId($value)
 * @mixin \Eloquent
 */
class PaymentLogs extends Model
{

    const ReplenishmentBalance = 1; // пополение баланса
    const SubscriptionPayment = 2; // пополение баланса

    public $timestamps = true;
    public $table = "payments_logs";

    public $fillable = [
        'user_id',
        'description',
        'payment_sum',
        'payment_number',
    ];
}
