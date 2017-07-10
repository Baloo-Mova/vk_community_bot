<?php

namespace App\Http\Controllers;

use App\Core\VK;
use App\Jobs\NewMessageReceived;
use App\Models\CallbackLog;
use App\Models\Errors;
use App\Models\User;
use App\Models\UserGroups;
use Illuminate\Http\Request;

class VkListenerController extends Controller
{
    public function index(Request $request, $id)
    {
        $addThisToList = $request->getContent();
        $item          = new CallbackLog();
        $item->data    = $addThisToList;
        $item->save();
        try {
            $data = json_decode($request->getContent(), true);
            switch ($data['type']) {
                case 'confirmation':
                    file_put_contents(storage_path('app/vklog.txt'), json_encode($data), 8);
                    $group = UserGroups::find($data['group_id']);
                    if (isset($group)) {
                        file_put_contents(storage_path('app/vklog.txt'), 'echo ' . $group->success_response, 8);
                        echo $group->success_response;
                        exit();
                    }
                    break;
                case 'message_new':
                    $this->newMessageReceived($data['object'], $data['group_id']);
                    break;
            }
        } catch (\Exception $ex) {
            $err       = new Errors();
            $err->text = $ex->getMessage();
            $err->url  = $ex->getLine();
            $err->save();
        }
    }

    public function newMessageReceived($data, $group_id)
    {
        $this->dispatch(new NewMessageReceived($data, $group_id));
        echo 'ok';
        exit();
    }
}
