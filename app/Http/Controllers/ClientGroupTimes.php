<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientGroupTimesAdd;
use App\Models\ClientGroups;
use App\Models\ListRules;
use Brian2694\Toastr\Facades\Toastr;
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
        $list_id = $request->get('client_group_id');
        $name = $request->get('name');
        $from = $request->get('from');
        $to = $request->get('to');

        if (!isset($list_id)) {
            Toastr::error("Отсутствует обязательный параметр!");
            return back();
        }

        $list = ListRules::where(['client_group_id' => $list_id])->first();
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
        $list = ListRules::find($id);

        if (!isset($list)) {
            Toastr::error("Временной отрезок с таким ID не найден!");
            return back();
        }

        $list->delete();

        Toastr::success("Удаление прошло успешно");
        return back();
    }

}
