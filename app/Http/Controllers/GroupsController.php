<?php

namespace App\Http\Controllers;

use App\Core\VK;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\UserGroups;
use App\Models\User;

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
            $vk = new VK(\Auth::user());
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
        $vk = new VK(\Auth::user());

        return redirect($vk->getGroupKeyRequest($id));
    }

}
