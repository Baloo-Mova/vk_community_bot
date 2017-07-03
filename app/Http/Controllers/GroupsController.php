<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GroupsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'logout']]);
    }

    public function index()
    {
        return view('groups.index', [
            'user' => \Auth::user()
        ]);
    }

    public function replenishmentBalance(Request $request)
    {



        $payment = new \Idma\Robokassa\Payment(
            '', '', '', true
        );

        $payment
            ->setInvoiceId($order->id)
            ->setSum($order->amount)
            ->setDescription('Payment for some goods');

        // redirect to payment url
        $user->redirect($payment->getPaymentUrl());
    }
}
