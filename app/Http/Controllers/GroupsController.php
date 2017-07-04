<?php

namespace App\Http\Controllers;

use App\Core\VK;
use App\Models\PaymentLogs;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\UserGroups;
use App\Models\User;
use App\Models\BotCommunityResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\ClientGroups;

class GroupsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'logout']]);
    }

    public function index()
    {
        $groups = \Auth::user()->groups;
        return view('groups.index', [
            'user' => \Auth::user(),
            'groups' => $groups
        ]);
    }

    public function addGroupCallback(Request $request)
    {
        $code = $request->get('code');
        if (isset($code)) {
            $vk = new VK();
            $vk->setUser(\Auth::user());
            if ( ! $vk->updateGroupAccessToken($code)) {
                Toastr::error('Не могу получить доступ к группе, попробуйте через 5 минут.', 'Ошибка');
            }
        } else {
            Toastr::error('Не могу получить доступ к группе, попробуйте через 5 минут.', 'Ошибка');
        }

        return redirect(route('groups.index'));
    }

    public function addGroup($id)
    {
        $vk = new VK();
        $vk->setUser(\Auth::user());
        return redirect($vk->getGroupKeyRequest($id));
    }

    public function responseScript($group_id)
    {
        $responses = BotCommunityResponse::where(['group_id' => $group_id])->get();
        if(!isset($responses)){
            $responses = [];
        }
        $group = UserGroups::find($group_id);
        return view('groups.response', [
            'user' => \Auth::user(),
            'responses' => $responses,
            'group'  => isset($group) ? $group : []
        ]);
    }

    public function addResponseScript(Request $request)
    {
        $response = new BotCommunityResponse();
        $response->fill($request->all());
        $response->save();

        return back();
    }

    public function deleteResponseScript($id)
    {
        $response = BotCommunityResponse::find($id);
        $response->delete();

        return back();
    }

    public function changeResponseStatus($response_id, $status)
    {
        $response = BotCommunityResponse::find($response_id);
        $response->state = $status;
        $response->save();

        return json_encode(["success" => true]);
    }

    public function changeGroupBotStatus($group_id, $status)
    {
        $group = UserGroups::find($group_id);
        if(!$group->payed){
            Toastr::error('Возможность заблокирована для неоплаченных групп!', 'Ошибка');
            return back();
        }
        $group->status = $status;
        $group->save();

        return json_encode(["success" => true]);
    }


    public function editResponseScript(Request $request)
    {
        $id = $request->get('scenario_id');
        $response = BotCommunityResponse::find($id);
        $response->key = $request->get('key');
        $response->response = $request->get('response');
        $response->save();

        return back();
    }

    public function updateUserGroups()
    {
        $vk = new VK();
        $vk->setUser(\Auth::user());
        $vk->updateUserGroups();
        return back();
    }

    public function groupSettings($group_id)
    {
        $group = UserGroups::find($group_id);
        return view('groups.groupSettings', [
            "user"  => \Auth::user(),
            "group" => isset($group) ? $group : []
        ]);
    }

    public function newSubscription(Request $request)
    {
        $user = \Auth::user();
        $payment_sum = config('robokassa.community_one_month_price');
        $group_id = $request->get('group_id');

        if(!isset($group_id)){
            Toastr::error('Отсутствует обязательный (Id группы) параметр!', 'Ошибка');
            return back();
        }

        if($user->balance < $payment_sum){
            Toastr::error('На Вашем балансе недостаточно средств', 'Ошибка');
            return back();
        }

        $get_money = $user->decrement('balance', $payment_sum);

        if (!$get_money){
            Toastr::error('На Вашем балансе недостаточно средств', 'Ошибка');
            return back();
        }

        $group = UserGroups::where(['id' => $group_id])->first();
        if ( !isset($group)) {
            $user->increment('balance', $payment_sum);
            Toastr::error('Группа не найдена', 'Ошибка');
            return back();
        }

        $group->payed = 1;
        $group->payed_for = Carbon::now()->addDays(30);
        $group->save();

        PaymentLogs::insert([
            "user_id"      => $user->id,
            "description"  => PaymentLogs::SubscriptionPayment,
            "payment_sum"  => $payment_sum,
            "status"       => 1
        ]);

        Toastr::success('Подписка успешно оплачена', 'Оплачено');
        return back();

    }

    public function clientGroup($group_id)
    {
        $group = UserGroups::find($group_id);
        $groups = $group->clientGroups;

        return view('groups.clientGroup', [
            "user"     => \Auth::user(),
            "group_id" => $group_id,
            "groups"   => isset($groups) ? $groups : []
        ]);
    }

    public function addClientGroup(Request $request)
    {
        $clGroup = new ClientGroups();
        $clGroup->fill($request->all());
        $clGroup->save();

        return back();
    }

    public function editClientGroup(Request $request)
    {

    }

}
