<?php

namespace App\Http\Controllers;

use App\Models\Rates;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class RateController extends Controller
{
    public function index()
    {
        $data = Rates::all();

        return view('rates.index', [
            'user' => \Auth::user(),
            'data' => $data
        ]);
    }

    public function add(Request $request)
    {
        $name  = $request->get('name');
        $days  = $request->get('days');
        $price = $request->get('price');

        if ( ! isset($name) || ! isset($price) || ! isset($days)) {
            Toastr::error('Не заполнены нужные данные!');

            return back();
        }

        Rates::insert([
            'name'  => $name,
            'days'  => $days,
            'price' => $price
        ]);

        return back();
    }

    public function update(Request $request)
    {
        $name  = $request->get('name');
        $days  = $request->get('days');
        $price = $request->get('price');
        $id    = $request->get('id');

        $rate = Rates::find($id);
        if ( ! isset($rate)) {
            Toastr::error('Чет тут не то!');

            return back();
        }

        $rate->name  = $name;
        $rate->days  = $days;
        $rate->price = $price;
        $rate->save();

        Toastr::success('Редактирование успешно!');

        return back();
    }

    public function delete(Request $request, $id)
    {
        $rate = Rates::find($id);
        if ( ! isset($rate)) {
            Toastr::error('Чет тут не то!');

            return back();
        }

        $rate->delete();

        Toastr::success('Удаление успешно!');

        return back();
    }
}
