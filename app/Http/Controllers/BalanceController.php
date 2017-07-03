<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentLogs;
use App\Models\User;

class BalanceController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'logout']]);
    }

    public function index()
    {
        return view('balance.index', [
            'user' => \Auth::user()
        ]);
    }

    /*
     * Пополнение баланса
     */
    public function replenishment(Request $request)
    {

        if (empty($request->get('sum')) || $request->get('sum') == 0) {
            return back();
        }

        $sum = $request->get('sum');

        $payment_id = PaymentLogs::max('id');
        $payment_id = empty($payment_id) ? 1 : $payment_id + 1;

        $payment = new \Idma\Robokassa\Payment(
            config('robokassa.login'),
            config('robokassa.demo_password1'),
            config('robokassa.demo_password2'),
            true
        );

        $payment
            ->setInvoiceId($payment_id)
            ->setSum($sum)
            ->setDescription('Пополнение баланса на ' . $sum);

        PaymentLogs::create([
            "user_id"        => \Auth::user()->id,
            "description"    => PaymentLogs::ReplenishmentBalance,
            "payment_sum"    => $sum
        ]);

        return redirect($payment->getPaymentUrl());
    }

    public function checkResult()
    {
        $payment = new \Idma\Robokassa\Payment(
            config('robokassa.login'),
            config('robokassa.demo_password1'),
            config('robokassa.demo_password2'),
            true
        );

        if ($payment->validateResult($_GET)){
            $order = PaymentLogs::find($payment->getInvoiceId());

            $answer = $payment->getSuccessAnswer();
            if(!empty($answer)){
                $order->invoice_id = $answer;
                $order->save();
            }else{
                return "Error";
            }
        }
    }

    public function checkSuccess()
    {
        $user_id = \Auth::user()->id;

        $payment = new \Idma\Robokassa\Payment(
            config('robokassa.login'),
            config('robokassa.demo_password1'),
            config('robokassa.demo_password2'),
            true
        );

        if ($payment->validateSuccess($_GET)) {
            $order = PaymentLogs::where(['id' => $payment->getInvoiceId()])->first();
            if ($payment->getSum() == $order->payment_sum) {
                $order->status = 1;
                $order->save();
                $user = User::find($user_id);
                $user->balance += $order->payment_sum;
                $user->save();
            }else{
                $order->invoice_id = 0;
                $order->save();
            }

        }

        return redirect('balance');

    }
}
