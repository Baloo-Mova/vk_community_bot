<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGroups;
use App\Models\BotCommunityResponse;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\PaymentLogs;
use Carbon\Carbon;

class GroupSettingsController extends Controller
{
    public function index($id)
    {
        $group = UserGroups::find($id);

        if ( ! $group->checkAccess()) {
            $group->removeControl();

            return back();
        }

        return view('groupSettings.index', [
            "user"     => \Auth::user(),
            "group_id" => $id,
            "group"    => isset($group) ? $group : [],
            "tab_name" => "settings"
        ]);
    }

    public function newSubscription(Request $request)
    {
        $user        = \Auth::user();
        $payment_sum = config('robokassa.community_one_month_price');
        $group_id    = $request->get('group_id');

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

        $group->payed     = 1;
        $group->payed_for = Carbon::now()->addDays(30);
        $group->save();

        PaymentLogs::insert([
            "user_id"     => $user->id,
            "description" => PaymentLogs::SubscriptionPayment,
            "payment_sum" => $payment_sum,
            "status"      => 1
        ]);

        Toastr::success('Подписка успешно оплачена', 'Оплачено');

        return back();
    }
}
