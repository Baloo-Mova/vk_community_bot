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

        $activated_groups = [];
        $non_activated_groups = [];

        foreach ($groups as $group){
            if($group->token !== NULL){
                $activated_groups[] = $group;
            }else{
                $non_activated_groups[] = $group;
            }
        }


        return view('groups.index', [
            'user'   => \Auth::user(),
            'activated_groups' => $activated_groups,
            'non_activated_groups' => $non_activated_groups,
            'activated_groups_numb' => count($activated_groups)
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

    public function updateUserGroups()
    {
        $vk = new VK();
        $vk->setUser(\Auth::user());
        $vk->updateUserGroups();

        return back();
    }

    public function deleteGroupPermissions($group_id)
    {
        dd($group_id);
    }
}
