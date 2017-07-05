<?php

namespace App\Http\Controllers;

use App\Core\VK;
use App\Http\Requests;
use App\Models\User;
use Socialite;

class SocialController extends Controller
{
    public function login()
    {
        return Socialite::with('vk')->redirect();
    }

    public function loginCallback()
    {
        $user = Socialite::with('vk')->stateless()->authUser();
        \Auth::login($user, true);

        return redirect()->intended('/');
    }

}