<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGroups;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\MassDelivery;
use Carbon\Carbon;

class MassDeliveryController extends Controller
{
    public function index($group_id)
    {
        $userGroup      = UserGroups::find($group_id);
        $massDeliveries = $userGroup->massdeliveries;
        $groups         = $userGroup->clientGroups;

        return view('massDelivery.index', [
            "user"       => \Auth::user(),
            "group"      => $userGroup,
            "group_id"   => $group_id,
            "deliveries" => $massDeliveries,
            "groups"     => isset($groups) ? $groups : [],
            "tab_name"   => "delivery"
        ]);
    }

    public function add(Request $request)
    {
        if (empty($request->get('message'))) {
            Toastr::error('Укажите поле сообшение', 'Ошибка');

            return back();
        }

        $in         = $request->get('in');
        $in_arr     = [];
        $not_in     = $request->get('not_in');
        $not_in_arr = [];
        $result     = [];

        if ( ! empty($in)) {
            foreach ($in as $i) {
                $in_arr[] = $i;
            }
        }

        if ( ! empty($not_in)) {
            foreach ($not_in as $n) {
                $not_in_arr[] = $n;
            }
        }

        if (count($in_arr) > 0) {
            $result["in"] = $in_arr;
        } else {
            $result["in"] = [];
        }

        if (count($not_in) > 0) {
            $result["not"] = $not_in;
        } else {
            $result["not"] = [];
        }

        if(count($not_in) - count($in_arr) == 0){
            Toastr::error('Вы не указали кому рассылать.','Ошибка');
            return back();
        }

        $delivery = new MassDelivery();
        $delivery->fill($request->all());
        $delivery->rules = json_encode($result);
        $then_send = $request->get('when_send');
        if (empty($then_send)) {
            $delivery->when_send = Carbon::now();
        }else{
            $delivery->when_send = Carbon::parse($then_send)->format("y-m-d H:m:s");
        }
        $delivery->save();

        Toastr::success('Рассылка успешно добавлена', 'Добавлено');

        return back();
    }

    public function delete($delivery_id)
    {
        $delivery = MassDelivery::find($delivery_id);
        if ( ! isset($delivery)) {
            Toastr::error('Рассылка не найдена!', 'Ошибка');

            return back();
        }
        $delivery->delete();

        Toastr::success('Рассылка успешно удалена', 'Удалено');

        return back();
    }
}
