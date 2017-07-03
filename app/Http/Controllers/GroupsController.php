<?php

namespace App\Http\Controllers;

use App\Core\VK;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\UserGroups;
use App\Models\User;
use App\Models\BotCommunityResponse;
use Carbon\Carbon;

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
        return view('groups.response', [
            'user' => \Auth::user(),
            'responses' => $responses,
            'group_id'  => $group_id
        ]);
    }

    public function addResponseScript(Request $request)
    {
        $response = new BotCommunityResponse();
        $response->fill($request->all());
        $response->last_time_ckecked = Carbon::now();
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

}
