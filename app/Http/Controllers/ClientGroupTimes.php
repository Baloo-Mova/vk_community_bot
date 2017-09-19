<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientGroupTimesAdd;
use App\Models\ClientGroups;
use App\Models\ListRules;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClientGroupTimes extends Controller
{
    public function index($id)
    {
        $clientGroup = ClientGroups::find($id);


        return view('clientGroups.times.index', [
            "user" => \Auth::user(),
            'times' => $clientGroup->listRules,
            'real_group_id' => $clientGroup->group_id,
            'group_id' => $id
        ]);
    }

    public function add(ClientGroupTimesAdd $request)
    {
        $new = new ListRules();

        $data = $request->all();
        $data['from'] = Carbon::createFromFormat("d-m-Y H:i:s", trim($data['from']) . ":00");
        $data['to'] = Carbon::createFromFormat("d-m-Y H:i:s", trim($data['to']) . ":00");

        $new->fill($data);
        $new->save();

        return back();
    }

    public function edit(Request $request)
    {

    }
}
