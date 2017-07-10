<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BotCommunityResponse;
use App\Models\UserGroups;
use Brian2694\Toastr\Facades\Toastr;

class GroupTasksController extends Controller
{
    public function index($group_id)
    {
        $responses = BotCommunityResponse::where(['group_id' => $group_id])->get();
        if ( ! isset($responses)) {
            $responses = [];
        }

        $group  = UserGroups::find($group_id);
        $groups = $group->clientGroups;

        return view('groupTasks.index', [
            'user'          => \Auth::user(),
            'responses'     => $responses,
            "group_id" => $group_id,
            'group'         => isset($group) ? $group : [],
            'client_groups' => isset($groups) ? $groups : [],
            "tab_name"   => "task"
        ]);
    }

    public function add(Request $request)
    {
        $response = new BotCommunityResponse();
        $response->fill($request->all());
        $response->save();

        Toastr::success('Сценарий успешно добавлен', 'Успешно');

        return back();
    }

    public function edit(Request $request)
    {
        $id                     = $request->get('scenario_id');
        $response               = BotCommunityResponse::find($id);
        $response->key          = $request->get('key');
        $response->response     = $request->get('response');
        $response->action_id    = $request->get('action_id');
        $response->add_group_id = $request->get('add_group_id');
        $response->save();

        Toastr::success('Сценарий успешно отредактирован', 'Успешно');

        return back();
    }

    public function delete($id)
    {
        $response = BotCommunityResponse::find($id);
        $response->delete();

        Toastr::success('Сценарий успешно удален', 'Успешно');

        return back();
    }

}
