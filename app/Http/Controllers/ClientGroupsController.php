<?php

namespace App\Http\Controllers;

use App\Models\AutoDelivery;
use App\Models\Funnels;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\UserGroups;
use App\Core\VK;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Clients;
use App\Models\ClientGroups;
use Illuminate\Support\Facades\Response;

class ClientGroupsController extends Controller
{

    public function index($group_id)
    {
        $group = UserGroups::find($group_id);
        $groups = $group->clientGroups;

        return view('clientGroups.index', [
            "user" => \Auth::user(),
            "group" => $group,
            "group_id" => $group_id,
            "real_group_id" => $group->group_id,
            "groups" => isset($groups) ? $groups : [],
            "tab_name" => "lists"
        ]);
    }

    public function addGroup(Request $request)
    {
        $clGroup = new ClientGroups();
        $clGroup->show_in_list = isset($request->need_show) ? true : false;
        $clGroup->fill($request->all());
        $clGroup->save();

        Toastr::success('Список успешно добавлен!', 'Добавлено');

        return back();
    }

    public function group($group_id)
    {
        $data = ClientGroups::find($group_id);
        $users = $data->users;

        return view('clientGroups.group', [
            "user" => \Auth::user(),
            "group_id" => $group_id,
            "data" => $data,
            "users" => isset($users) ? $users : []
        ]);
    }

    public function editGroup(Request $request)
    {
        $clGroups = ClientGroups::find($request->get('group_id'));
        if (!isset($clGroups)) {
            Toastr::error('Группа не найдена', 'Ошибка');

            return back();
        }
        $clGroups->show_in_list = isset($request->need_show) ? true : false;
        $clGroups->name = $request->get('name');
        $clGroups->save();
        Toastr::success('Список успешно отредактирован!', 'Успешно');

        return back();
    }

    public function deleteGroup($group_id)
    {
        $clGroups = ClientGroups::find($group_id);
        $clGroups->delete();
        Clients::where(['client_group_id' => $group_id])->delete();

        return back();
    }

    public function addUser(Request $request)
    {
        set_time_limit(0);
        $group_id = $request->get('client_group_id');
        $userIds = [];
        try {
            $group = ClientGroups::find($group_id)->group;
        } catch (\Exception $ex) {
            Toastr::error('Ошибка добавления (Отсутствует группа?)', 'Ошибка');

            return back();
        }

        $users_str = $request->get('users');
        if (!empty($users_str)) {
            $users = array_map('trim', explode("\n", $users_str));
            $userIds = array_filter(array_merge($userIds, $users));
        }

        $vk = new VK();
        $vk->setGroup($group);
        $vk->setUser(\Auth::user());

        $array = array_chunk($userIds, 500);

        $userIds = [];
        foreach ($array as $item) {
            $user_info = $vk->getUserInfo($item);
            $userIds = array_merge($userIds, $user_info);
            sleep(1);
        }

        $funnel = Funnels::with('times')->where(['client_group_id' => $group_id])->get();
        $itemsToSend = [];
        foreach ($funnel as $item) {
            $itemsToSend = array_merge($itemsToSend, $item->times->toArray());
        }

        $data = Clients::where('client_group_id', '=', $group_id)->whereIn('vk_id',
            array_column($userIds, 'id'))->get()->toArray();

        $VkIds = array_column($data, 'vk_id');
        $insert = [];
        $autoSender = [];
        foreach ($userIds as $item) {
            $index = array_search($item['id'], $VkIds);
            if ($index !== false) {
                foreach ($itemsToSend as $itemSend) {
                    $time = Carbon::createFromFormat("Y-m-d H:i:s",
                            $data[$index]['created'])->timestamp + $itemSend['time'];
                    if ($time > time()) {
                        $autoSender[] = [
                            'vk_id' => $item['id'],
                            'client_group_id' => $group_id,
                            'group_id' => $group->group_id,
                            'funnel_id' => $itemSend['id'],
                            'message' => $itemSend['text'],
                            'when_send' => $time,
                            'media' => $itemSend['media']
                        ];
                    }
                }

                continue;
            }

            $insert[] = [
                'client_group_id' => $group_id,
                'vk_id' => $item["id"],
                'first_name' => $item["first_name"],
                'last_name' => $item["last_name"],
                'avatar' => $item["photo_100"],
                'group_id' => $group->group_id,
                'can_send' => 1,
                'created' => Carbon::now()
            ];

            foreach ($itemsToSend as $itemSend) {
                $autoSender[] = [
                    'vk_id' => $item['id'],
                    'client_group_id' => $group_id,
                    'funnel_id' => $itemSend['id'],
                    'group_id' => $group->group_id,
                    'media' => $itemSend['media'],
                    'message' => $itemSend['text'],
                    'when_send' => time() + $itemSend['time'],
                ];
            }

            if (count($autoSender) > 1000) {
                AutoDelivery::insert($autoSender);
                $autoSender = [];
            }
        }

        if (count($autoSender) > 0) {
            AutoDelivery::insert($autoSender);
        }

        if (count($insert) > 0) {
            Clients::insert($insert);
        }

        Toastr::success('Пользователи успешно добавлены!', 'Добавлено');

        return back();
    }

    public function massDeleteClientGroup(Request $request)
    {
        $group_id = $request->get('client_group_id');
        $userIds = [];
        $vk_id_str = $request->get('vk_id');

        if (!empty($vk_id_str)) {
            $userIds[] = $vk_id_str;
        }

        $users_str = $request->get('users');
        if (!empty($users_str)) {
            $users = array_map('trim', explode("\r\n", $users_str));
            $userIds = array_filter(array_merge($userIds, $users));
        }

        $vk = new VK();
        $vk->setUser(\Auth::user());

        $array = array_chunk($userIds, 999);
        $userIds = [];
        foreach ($array as $item) {
            $userIds = array_merge($userIds, array_column($vk->getUserInfo($item), 'id'));
        }

        Clients::where('client_group_id', '=', $group_id)->whereIn('vk_id', $userIds)->delete();

        Toastr::success('Пользователи удачно удалены', 'Удалено');

        return back();
    }

    public function deleteUser($user_id)
    {
        $client = Clients::find($user_id);
        if (!isset($client)) {
            Toastr::error('Пользователь не найден!', 'Ошибка');

            return back();
        }
        $client->delete();
        Toastr::success('Пользователь удачно удален', 'Удалено');

        return back();
    }

    public function downloadList(Request $request, $group_id){
        $clients = Clients::whereClientGroupId($group_id)->get()->toArray();
        $file = storage_path('app/download/'.uniqid('id').".txt");
        $ids = array_column($clients,'vk_id');
        file_put_contents($file, implode("\n", $ids));

        return Response::download($file);
    }
}
