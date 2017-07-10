<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VkListenerController extends Controller
{
    public function index(Request $request, $id)
    {
        $data = json_decode($request->getContent());
        file_put_contents(storage_path('app/test.txt'), $request->getContent());
        if ($data['type'] == 'confirmation') {
            return "740cb521";
        }
    }
}
