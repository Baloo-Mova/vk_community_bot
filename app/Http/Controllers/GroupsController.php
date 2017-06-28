<?php

namespace App\Http\Controllers;

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
}
