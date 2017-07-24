<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentLogs;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;

class BalanceController extends Controller
{

    public function index()
    {
        $user = \Auth::user();

        return view('balance.index', [
            'user'     => $user,
            'payments' => $user->payments
        ]);
    }

    /*
     * Пополнение баланса
     */
    public function replenishment(Request $request)
    {
        $sum = $request->get('sum');
        if (empty($sum) || $sum == 0) {
            return back();
        }

        $payment              = new PaymentLogs();
        $payment->user_id     = \Auth::user()->id;
        $payment->description = PaymentLogs::ReplenishmentBalance;
        $payment->payment_sum = $sum;
        $payment->save();

        $kassa = new \Idma\Robokassa\Payment(config('robokassa.login'), config('robokassa.password1'),
            config('robokassa.password2'));

        $kassa->setInvoiceId($payment->id)->setSum($sum)->setDescription('Пополнение баланса на ' . $sum);

        return redirect($kassa->getPaymentUrl());
    }

    public function checkResult()
    {
        $payment = new \Idma\Robokassa\Payment(config('robokassa.login'), config('robokassa.password1'),
            config('robokassa.password2'));

        if ($payment->validateResult($_GET)) {
            $order = PaymentLogs::find($payment->getInvoiceId());
            if ( ! isset($order)) {
                abort(401);
            }

            $user = User::find($order->user_id);
            if ( ! isset($user)) {
                abort(404);
            }

            if ($order->status > 0) {
                abort(401);
            }

            $order->status = 1;
            $order->save();

            $user->increment('balance', $payment->getSum());

            return $payment->getSuccessAnswer();
        }
    }

    public function checkSuccess()
    {
        $payment = new \Idma\Robokassa\Payment(config('robokassa.login'), config('robokassa.password1'),
            config('robokassa.password2'));

        if ($payment->validateSuccess($_GET)) {
            Toastr::success('Ваш баланс пополнен на ' . $payment->getSum(), 'Успешная оплата');
        } else {
            Toastr::error("Обратитесь к администратору", 'Ошибка');
        }

        return redirect('balance');
    }

    public function checkFair()
    {
        $order = PaymentLogs::find($_GET["InvId"]);
        if (isset($order)) {
            $order->status = 0;
            $order->save();
        }

        Toastr::error('Отмена оплаты :(', 'Зря!!!');

        return redirect('balance');
    }

}
