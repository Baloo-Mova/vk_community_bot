<?php

namespace App\Http\Controllers;

use App\Models\AutoDelivery;
use App\Models\Clients;
use App\Models\Funnels;
use App\Models\FunnelsTime;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\UserGroups;
use Brian2694\Toastr\Facades\Toastr;

class FunnelsController extends Controller
{
    public function index($group_id)
    {
        $group   = UserGroups::find($group_id);
        $funnels = $group->funnels;

        $clientsGroups = $group->clientGroups;

        return view('funnels.index', [
            "user"          => \Auth::user(),
            "group"         => $group,
            "group_id"      => $group->id,
            "funnels"       => $funnels,
            "client_groups" => $clientsGroups,
            "tab_name"      => "funnels"
        ]);
    }

    public function add(Request $request)
    {
        if ( ! $request->has('client_group_id') || ! $request->has('name')) {
            Toastr::error('Заполнены не все данные', 'Ошибка');

            return back();
        }
        $funnel = new Funnels();
        $funnel->fill($request->all());
        $funnel->save();
        Toastr::success('Воронка успешно добавлена!', 'Добавлено');

        return back();
    }

    public function edit(Request $request)
    {
        return;
        $funnel = Funnels::find($request->get('funnel_id'));
        if ( ! isset($funnel)) {
            Toastr::error('Воронки с таким ID не существует!', 'Ошибка');

            return back();
        }
        $name = $request->get('name');
        if ( ! isset($name)) {
            Toastr::error('Пожалуйста, укажите новое имя воронки!', 'Ошибка');

            return back();
        }
        $funnel->name            = $name;
        $funnel->client_group_id = $request->get('client_group_id');
        $funnel->save();
        Toastr::success('Воронка успешно изменена!', 'Успешно');

        return back();
    }

    public function delete($funnel_id)
    {
        $funnel = Funnels::find($funnel_id);
        if ( ! isset($funnel)) {
            Toastr::error('Воронки с таким ID не существует!', 'Ошибка');

            return back();
        }
        FunnelsTime::where(['funell_id' => $funnel_id])->delete();
        $funnel->delete();
        Toastr::success('Воронка успешно удалена!', 'Удалено');

        return back();
    }

    public function show($funnel_id)
    {
        $funnel = Funnels::find($funnel_id);
        if ( ! isset($funnel)) {
            Toastr::error('Воронки с таким ID не существует!', 'Ошибка');

            return back();
        }
        $times = $funnel->times;

        return view('funnels.show', [
            "times"  => isset($times) ? $times : [],
            "funnel" => $funnel,
            "user"   => \Auth::user()
        ]);
    }

    public function addTime(Request $request)
    {

        $time = 0;
        $d    = $request->get('days');
        $h    = $request->get('hours');
        $m    = $request->get('minutes');
        $time += intval($d) * 86400;
        $time += intval($h) * 3600;
        $time += intval($m) * 60;

        if ($time == 0 || ! $request->has('text')) {
            Toastr::error('Поля не заполнены', 'Ошибка');

            return back();
        }

        $ftime            = new FunnelsTime();
        $ftime->funell_id = $request->get('funnel_id');
        $ftime->time      = $time;
        $ftime->text      = $request->get('text');
        $ftime->save();

        $funnel = $ftime->funnel;
        $group  = $funnel->group;

        $clients = Clients::whereClientGroupId($funnel->client_group_id)->get();

        $array = [];
        foreach ($clients as $item) {
            $array[] = [
                'vk_id'           => $item->vk_id,
                'message'         => $ftime->text,
                'client_group_id' => $item->client_group_id,
                'group_id'        => $group->group_id,
                'when_send'       => Carbon::createFromFormat("Y-m-d H:i:s", $item->created)->timestamp + $time,
                'funnel_id'       => $ftime->id
            ];
        }

        AutoDelivery::insert($array);

        Toastr::success('Время успешно добавлено!', 'Успешно');

        return back();
    }

    public function editTime(Request $request)
    {
        return;
        $time = 0;
        $d    = $request->get('days');
        $h    = $request->get('hours');
        $m    = $request->get('minutes');
        $time += intval($d) * 86400;
        $time += intval($h) * 3600;
        $time += intval($m) * 60;

        if ($time == 0) {
            Toastr::error('Неверно указано время', 'Ошибка');

            return back();
        }

        $ftime = FunnelsTime::find($request->get('time_id'));
        if ( ! isset($ftime)) {
            Toastr::error('Времени с таким ID не существует!', 'Ошибка');

            return back();
        }
        $ftime->time = $time;
        $ftime->text = $request->get('text');
        $ftime->save();

        Toastr::success('Время успешно изменено!', 'Успешно');

        return back();
    }

    public function deleteTime($time_id)
    {
        $time = FunnelsTime::find($time_id);
        if ( ! isset($time)) {
            Toastr::error('Времени с таким ID не существует!', 'Ошибка');

            return back();
        }
        $time->delete();

        AutoDelivery::where(['funnel_id' => $time_id])->delete();
        Toastr::success('Время успешно удалено!', 'Удалено');

        return back();
    }

}
