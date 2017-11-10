<?php

namespace App\Http\Controllers;

use App\Http\Requests\BotCommunityResponseTimeAdd;
use App\Models\BotCommunityResponse;
use App\Models\BotCommunityTime;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GroupTasksTimeController extends Controller
{
    public function index($id)
    {
        $clientGroup = BotCommunityResponse::with('timeList')->find($id);
        return view('groupTasks.times.index', [
            "user" => \Auth::user(),
            'times' => $clientGroup->timeList,
            'group_task_id' => $id,
            'group_id' => $clientGroup->group_id
        ]);
    }

    public function add(BotCommunityResponseTimeAdd $request)
    {
        $new = new BotCommunityTime();

        $data = $request->all();
        $data['from'] = Carbon::createFromFormat("d-m-Y H:i:s", trim($data['from']) . ":00");
        $data['to'] = Carbon::createFromFormat("d-m-Y H:i:s", trim($data['to']) . ":00");

        if ($data['from'] > $data['to']) {
            Toastr::error('Не верно введены даты.', 'Ошибка');
            return back();
        }

        $new->fill($data);
        $new->save();

        return back();
    }

    public function edit(Request $request)
    {
        $list_id = $request->get('bot_community_response_id');
        $name = $request->get('name');
        $from = $request->get('from');
        $to = $request->get('to');

        if (!isset($list_id)) {
            Toastr::error("Отсутствует обязательный параметр!");
            return back();
        }

        $list = BotCommunityTime::where(['bot_community_response_id' => $list_id])->first();
        if (!isset($list)) {
            Toastr::error("Временной отрезок с таким ID не найден!");
            return back();
        }

        $list->name = $name;
        $list->from = \Carbon\Carbon::parse($from)->toDateTimeString();
        $list->to = \Carbon\Carbon::parse($to)->toDateTimeString();

        if ($list->from > $list->to) {
            Toastr::error('Не верно введены даты.', 'Ошибка');
            return back();
        }


        $list->save();

        Toastr::success("Изменения успешно внесены!");
        return back();
    }

    public function delete($id)
    {
        $list = BotCommunityTime::find($id);

        if (!isset($list)) {
            Toastr::error("Временной отрезок с таким ID не найден!");
            return back();
        }

        $list->delete();

        Toastr::success("Удаление прошло успешно");
        return back();
    }
}
