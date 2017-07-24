<?php

namespace App\Http\Controllers;

use App\Models\Clients;
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

        $good = array_column(Clients::whereIn('client_group_id',
            $result["in"])->where(['can_send' => 1])->select('vk_id')->distinct()->get()->toArray(), 'vk_id');
        $bad  = array_column(Clients::whereIn('client_group_id',
            $result["not"])->where(['can_send' => 1])->select('vk_id')->distinct()->get()->toArray(), 'vk_id');

        $sendTo = array_diff($good, $bad);

        if (count($sendTo) < 1) {
            Toastr::error('Вы не указали кому рассылать.', 'Ошибка');

            return back();
        }

        $delivery = new MassDelivery();
        $delivery->fill($request->all());
        $delivery->rules = json_encode($result);
        $then_send       = $request->get('when_send');

        if (empty($then_send)) {
            $delivery->when_send = Carbon::now('Europe/Moscow');
        } else {
            $delivery->when_send = Carbon::createFromFormat("d-m-Y H:i", $then_send);
        }

        $delivery->save();
        Toastr::success('Рассылка успешно добавлена, в рассылке участвуют: ' . count($sendTo), 'Добавлено');

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
