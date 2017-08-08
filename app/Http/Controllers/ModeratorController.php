<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGroups;
use Illuminate\Support\Facades\Auth;

class ModeratorController extends Controller
{

    public function index($group_id)
    {
        $group = UserGroups::find($group_id);
        return view('moderator.index', [
            'group' => $group,
            'logs'  => $group->moderatorLogs,
            'user'  => \Auth::user()
        ]);
    }

}
