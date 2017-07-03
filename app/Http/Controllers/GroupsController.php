<?php

namespace App\Http\Controllers;

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

}
