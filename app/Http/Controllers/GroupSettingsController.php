<?php

namespace App\Http\Controllers;

use App\Models\Rates;
use Illuminate\Http\Request;
use App\Models\UserGroups;
use App\Models\BotCommunityResponse;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\PaymentLogs;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GroupSettingsController extends Controller
{
    public function index($id)
    {
        $group = UserGroups::find($id);

        if ( ! $group->checkAccess()) {
            $group->removeControl();
            Toastr::error('Видимо отсутствует доступ. Выдайте доступ заново.', "Проблема с группой");

            return back();
        }

        return view('groupSettings.index', [
            "user"     => \Auth::user(),
            "group_id" => $id,
            "group"    => isset($group) ? $group : [],
            "tab_name" => "settings",
            'prices'   => Rates::all()
        ]);
    }

    public function newSubscription(Request $request)
    {
        $user  = \Auth::user();
        $payId = $request->get('rate');

        if ($payId != 0) {
            if ( ! isset($payId)) {
                Toastr::error('Отсутствует обязательный (Имя тарифа) параметр!', 'Ошибка');

                return back();
            }

            $rate = Rates::find($payId);
            if ( ! isset($rate)) {
                Toastr::error('Тариф отсутствует', 'Ошибка');

                return back();
            }

            $daysToAdd   = $rate->days;
            $payment_sum = $rate->price;
        } else {
            $daysToAdd   = 2;
            $payment_sum = 0;
        }
        $group_id = $request->get('group_id');

        if ( ! isset($group_id)) {
            Toastr::error('Отсутствует обязательный (Id группы) параметр!', 'Ошибка');

            return back();
        }

        if ($user->balance < $payment_sum) {
            Toastr::error('На Вашем балансе недостаточно средств', 'Ошибка');

            return back();
        }

        $get_money = $user->decrement('balance', $payment_sum);

        if ( ! $get_money) {
            Toastr::error('На Вашем балансе недостаточно средств', 'Ошибка');

            return back();
        }

        $group = UserGroups::where(['id' => $group_id])->first();
        if ( ! isset($group)) {
            $user->increment('balance', $payment_sum);
            Toastr::error('Группа не найдена', 'Ошибка');

            return back();
        }

        $group->payed = 1;

        if ($payId == 0) {
            $user->trial_used = 1;
            $user->save();
        }

        if (is_null($group->payed_for)) {
            $group->payed_for = Carbon::now()->addDays($daysToAdd);
        } else {
            $group->payed_for = Carbon::createFromFormat('Y-m-d H:i:s', $group->payed_for)->addDays($daysToAdd);
        }
        $group->save();


        $payment              = new PaymentLogs();
        $payment->user_id     = \Auth::user()->id;
        $payment->description = PaymentLogs::SubscriptionPayment;
        $payment->payment_sum = $payment_sum;
        $payment->status = 1;
        $payment->save();

        foreach ($group->users as $user)
        {
            $user->resubscribe_notification_send = 0;
            $user->save();
        }

        Toastr::success('Подписка успешно оплачена', 'Оплачено');

        return back();
    }
}
