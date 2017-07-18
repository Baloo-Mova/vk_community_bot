<?php

namespace App\Http\Controllers;

use App\Models\Funnels;
use App\Models\FunnelsTime;
use Illuminate\Http\Request;
use App\Models\UserGroups;
use Brian2694\Toastr\Facades\Toastr;

class FunnelsController extends Controller
{
    public function index($group_id)
    {
        $group  = UserGroups::find($group_id);
        $funnels = $group->funnels;

        return view('funnels.index', [
            "user"     => \Auth::user(),
            "group"    => $group,
            "group_id" => $group->id,
            "funnels"  => $funnels,
            "tab_name" => "funnels"
        ]);
    }

    public function add(Request $request)
    {
        $funnel = new Funnels();
        $funnel->fill($request->all());
        $funnel->save();
        Toastr::success('Воронка успешно добавлена!', 'Добавлено');
        return back();
    }

    public function edit(Request $request)
    {
        $funnel = Funnels::find($request->get('funnel_id'));
        if(!isset($funnel)){
            Toastr::error('Воронки с таким ID не существует!', 'Ошибка');
            return back();
        }
        $name = $request->get('name');
        if(!isset($name)){
            Toastr::error('Пожалуйста, укажите новое имя воронки!', 'Ошибка');
            return back();
        }
        $funnel->name = $name;
        $funnel->save();
        Toastr::success('Воронка успешно изменена!', 'Успешно');
        return back();
    }

    public function delete($funnel_id){
        $funnel = Funnels::find($funnel_id);
        if(!isset($funnel)){
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
        if(!isset($funnel)){
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
        $d = $request->get('days');
        $h = $request->get('hours');
        $m = $request->get('minutes');
        $time += intval($d) * 86400;
        $time += intval($h) * 3600;
        $time += intval($m) * 60;

        if($time == 0){
            Toastr::error('Неверно указано время', 'Ошибка');
            return back();
        }

        $ftime = new FunnelsTime();
        $ftime->funell_id = $request->get('funnel_id');
        $ftime->time = $time;
        $ftime->text = $request->get('text');
        $ftime->save();

        Toastr::success('Время успешно добавлено!', 'Успешно');
        return back();
    }

    public function editTime(Request $request)
    {

        $time = 0;
        $d = $request->get('days');
        $h = $request->get('hours');
        $m = $request->get('minutes');
        $time += intval($d) * 86400;
        $time += intval($h) * 3600;
        $time += intval($m) * 60;

        if($time == 0){
            Toastr::error('Неверно указано время', 'Ошибка');
            return back();
        }

        $ftime = FunnelsTime::find($request->get('time_id'));
        if(!isset($ftime)){
            Toastr::error('Времени с таким ID не существует!', 'Ошибка');
            return back();
        }
        $ftime->time = $time;
        $ftime->text = $request->get('text');
        $ftime->save();

        Toastr::success('Время успешно изменено!', 'Успешно');
        return back();
    }

    public function deleteTime($time_id){
        $time = FunnelsTime::find($time_id);
        if(!isset($time)){
            Toastr::error('Времени с таким ID не существует!', 'Ошибка');
            return back();
        }
        $time->delete();
        Toastr::success('Время успешно удалено!', 'Удалено');
        return back();
    }

}
