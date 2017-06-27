<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Socialite;

class SocialController extends Controller
{
    public function login()
    {
        return Socialite::with('vk')->redirect();
    }

    public function callback()
    {
        $user = Socialite::with('vk')->stateless()->authUser();
        \Auth::login($user, true);

        return redirect()->intended('/');
    }

}