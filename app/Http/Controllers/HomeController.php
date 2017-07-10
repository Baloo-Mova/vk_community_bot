<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'logout']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', [
            'user' => \Auth::user()
        ]);
    }

    public function login()
    {
        return view('login');
    }

    public function logout()
    {
        \Auth::logout();

        return redirect('/login');
    }

    public function inWorkPage()
    {
        return view('inwork', [
            "user" => \Auth::user()
        ]);
    }
}
