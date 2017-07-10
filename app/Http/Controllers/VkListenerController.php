<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VkListenerController extends Controller
{
    public function index(Request $request, $id)
    {
        $data = json_decode($request->getContent(), true);
        if ($data['type'] == 'confirmation') {
            return "740cb521";
        }

        
    }
}
