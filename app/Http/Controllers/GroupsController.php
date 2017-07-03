<?php

namespace App\Http\Controllers;

use App\Core\VK;
use Brian2694\Toastr\Facades\Toastr;
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
