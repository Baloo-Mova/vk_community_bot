<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentLogs;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;

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
            if(empty($order)){
                Toastr::error('Транзакция с таким Id не найдена!',
                    'Ошибка',
                    ["positionClass" => "toast-bottom-right"]);
                return redirect('balance');
            }
            $answer = $payment->getSuccessAnswer();
            if(!empty($answer)){
                $order->invoice_id = $answer;
                $order->save();
            }else{
                Toastr::error('Ошибка валидации',
                    'Ошибка',
                    ["positionClass" => "toast-bottom-right"]
                );
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
            if(empty($order)){
                Toastr::error('Транзакция с таким Id не найдена!',
                    'Ошибка',
                    ["positionClass" => "toast-bottom-right"]);
                return redirect('balance');
            }
            if($order->status != -1){
                Toastr::error('Эта операция уже выполнена ', 'Ошибка', ["positionClass" => "toast-bottom-right"]);
                return redirect('balance');
            }
            if ($payment->getSum() == $order->payment_sum) {
                $order->status = 1;
                $order->save();
                $user = User::find($user_id);
                $user->balance += $order->payment_sum;
                $user->save();
            }else{
                $order->invoice_id = 0;
                $order->save();
                Toastr::error('Ваш баланс пополнен на '.$order->payment_sum,
                    'Ошибка',
                    ["positionClass" => "toast-bottom-right"]
                );
                return redirect('balance');
            }

        }

        Toastr::success('Ваш баланс пополнен на '.$order->payment_sum,
            'Успешная оплата',
            ["positionClass" => "toast-bottom-right"]
        );
        return redirect('balance');

    }

    public function checkFair()
    {
        $order = PaymentLogs::where(['id' => $_GET["InvId"]])->first();
        if(!empty($order)){
            $order->status = 0;
            $order->save();
        }

        Toastr::error('Отмена оплаты ',
            'Ошибка',
            ["positionClass" => "toast-bottom-right"]
        );
        return redirect('balance');

    }

}
