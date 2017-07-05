<?php

namespace App\Http\Controllers;

use App\Core\VK;
use App\Models\Clients;
use App\Models\PaymentLogs;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\UserGroups;
use App\Models\User;
use App\Models\BotCommunityResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\ClientGroups;
use App\Models\MassDelivery;

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
            'user'   => \Auth::user(),
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
        if ( ! isset($responses)) {
            $responses = [];
        }

        $group  = UserGroups::find($group_id);
        $groups = $group->clientGroups;

        return view('groups.response', [
            'user'          => \Auth::user(),
            'responses'     => $responses,
            'group'         => isset($group) ? $group : [],
            'client_groups' => isset($groups) ? $groups : []
        ]);
    }

    public function addResponseScript(Request $request)
    {
        $response = new BotCommunityResponse();
        $response->fill($request->all());
        $response->save();

        Toastr::success('Сценарий успешно добавлен', 'Успешно');

        return back();
    }

    public function deleteResponseScript($id)
    {
        $response = BotCommunityResponse::find($id);
        $response->delete();

        Toastr::success('Сценарий успешно удален', 'Успешно');

        return back();
    }

    public function changeResponseStatus($response_id, $status)
    {
        $response        = BotCommunityResponse::find($response_id);
        $response->state = $status;
        $response->save();

        return json_encode(["success" => true]);
    }

    public function changeGroupBotStatus($group_id, $status)
    {
        $group = UserGroups::find($group_id);
        if ( ! $group->payed) {
            Toastr::error('Возможность заблокирована для неоплаченных групп!', 'Ошибка');

            return back();
        }
        $group->status = $status;
        $group->save();

        return json_encode(["success" => true]);
    }

    public function editResponseScript(Request $request)
    {
        $id                     = $request->get('scenario_id');
        $response               = BotCommunityResponse::find($id);
        $response->key          = $request->get('key');
        $response->response     = $request->get('response');
        $response->action_id    = $request->get('action_id');
        $response->add_group_id = $request->get('add_group_id');
        $response->save();

        Toastr::success('Сценарий успешно отредактирован', 'Успешно');

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

    public function clientGroup($group_id)
    {
        $group  = UserGroups::find($group_id);
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
        $clGroups = ClientGroups::find($request->get('group_id'));
        if ( ! isset($clGroups)) {
            Toastr::error('Группа не найдена', 'Ошибка');

            return back();
        }
        $clGroups->name = $request->get('name');
        $clGroups->save();

        return back();
    }

    public function deleteClientGroup($group_id)
    {
        $clGroups = ClientGroups::find($group_id);
        $clGroups->delete();
        Clients::where(['client_group_id' => $group_id])->delete();

        return back();
    }

    public function clientGroupsUsers($group_id)
    {
        $data  = ClientGroups::find($group_id);
        $users = $data->users;

        return view('groups.clientGroupsUsers', [
            "user"     => \Auth::user(),
            "group_id" => $group_id,
            "data"     => $data,
            "users"    => isset($users) ? $users : []
        ]);
    }

    public function addClientGroupUser(Request $request)
    {
        $group_id  = $request->get('client_group_id');
        $userIds   = [];
        $vk_id_str = $request->get('vk_id');

        if ( ! empty($vk_id_str)) {
            $userIds[] = $vk_id_str;
        }

        $users_str = $request->get('users');
        if ( ! empty($users_str)) {
            $users   = array_map('trim', explode("\r\n", $users_str));
            $userIds = array_filter(array_merge($userIds, $users));
        }

        $vk = new VK();
        $vk->setUser(\Auth::user());

        $array   = array_chunk($userIds, 999);
        $userIds = [];
        foreach ($array as $item) {
            $userIds = array_merge($userIds, array_column($vk->getUserInfo($item), 'id'));
        }

        Clients::where('client_group_id', '=', $group_id)->whereIn('vk_id', $userIds)->delete();

        $insert = [];
        foreach ($userIds as $item) {
            $insert[] = [
                'client_group_id' => $group_id,
                'vk_id'           => $item
            ];
        }

        if (count($insert) > 0) {
            Clients::insert($insert);
        }

        Toastr::success('Пользователи успешно добавлены!', 'Добавлено');

        return back();
    }

    public function deleteClientGroupUser($user_id)
    {
        $client = Clients::find($user_id);
        if ( ! isset($client)) {
            Toastr::error('Пользователь не найден!', 'Ошибка');

            return back();
        }
        $client->delete();

        return back();
    }

    public function massDelivery($group_id)
    {
        $userGroup      = UserGroups::find($group_id);
        $massDeliveries = $userGroup->massdeliveries;
        $groups         = $userGroup->clientGroups;

        return view('groups.massDelivery', [
            "user"       => \Auth::user(),
            "group_id"   => $group_id,
            "deliveries" => $massDeliveries,
            "groups"     => isset($groups) ? $groups : []
        ]);
    }

    public function addMassDelivery(Request $request)
    {
        if (empty($request->get('message'))) {
            Toastr::error('Укажите поле сообшение', 'Ошибка');

            return back();
        }

        $in         = $request->get('in');
        $in_arr     = [];
        $not_in     = $request->get('not_in');
        $not_in_arr = [];
        $result     = [];

        if ( ! empty($in)) {
            foreach ($in as $i) {
                $in_arr[] = $i;
            }
        }

        if ( ! empty($not_in)) {
            foreach ($not_in as $n) {
                $not_in_arr[] = $n;
            }
        }

        if (count($in_arr) > 0) {
            $result["in"] = $in_arr;
        } else {
            $result["in"] = [];
        }

        if (count($not_in) > 0) {
            $result["not"] = $not_in;
        } else {
            $result["not"] = [];
        }

        $delivery = new MassDelivery();
        $delivery->fill($request->all());
        $delivery->rules = json_encode($result);
        if (empty($request->get('when_send'))) {
            $delivery->when_send = Carbon::now();
        }
        $delivery->save();

        Toastr::success('Рассылка успешно добавлена', 'Добавлено');

        return back();
    }

    public function deleteMassDelivery($delivery_id)
    {
        $delivery = MassDelivery::find($delivery_id);
        if ( ! isset($delivery)) {
            Toastr::error('Рассылка не найдена!', 'Ошибка');

            return back();
        }
        $delivery->delete();

        Toastr::success('Рассылка успешно удалена', 'Удалено');

        return back();
    }

    public function massDeleteClientGroup(Request $request)
    {
        $group_id  = $request->get('client_group_id');
        $userIds   = [];
        $vk_id_str = $request->get('vk_id');

        if ( ! empty($vk_id_str)) {
            $userIds[] = $vk_id_str;
        }

        $users_str = $request->get('users');
        if ( ! empty($users_str)) {
            $users   = array_map('trim', explode("\r\n", $users_str));
            $userIds = array_filter(array_merge($userIds, $users));
        }

        $vk = new VK();
        $vk->setUser(\Auth::user());

        $array   = array_chunk($userIds, 999);
        $userIds = [];
        foreach ($array as $item) {
            $userIds = array_merge($userIds, array_column($vk->getUserInfo($item), 'id'));
        }

        Clients::where('client_group_id', '=', $group_id)->whereIn('vk_id', $userIds)->delete();

        Toastr::success('Пользователи удачно удалены', 'Удалено');

        return back();
    }
}
