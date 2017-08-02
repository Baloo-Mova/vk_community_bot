<?php

namespace App\Http\Controllers;

use App\Core\VK;
use App\Jobs\NewMessageReceived;
use App\Models\CallbackLog;
use App\Models\Clients;
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

            $group = UserGroups::whereGroupId($data['group_id'])->first();
            if (isset($group)) {
                if (($group->payed == 0 || $group->status == 0) && $data['type'] != 'confirmation') {
                    echo "ok";
                    exit();
                }
            }
            switch ($data['type']) {
                case 'confirmation':
                    $group = UserGroups::whereGroupId($data['group_id'])->first();
                    if (isset($group)) {
                        echo $group->success_response;
                        exit();
                    }
                    break;
                case 'message_new':
                    $this->newMessageReceived($data['object'], $data['group_id']);
                    break;
                case 'message_allow':
                    $this->setAllow($data['object']['user_id'], $data['group_id']);
                    break;
                case 'message_deny':
                    $this->setDeny($data['object']['user_id'], $data['group_id']);
                    break;
            }
        } catch (\Exception $ex) {
            $err       = new Errors();
            $err->text = $ex->getMessage();
            $err->url  = $ex->getLine();
            $err->save();
        }
        echo 'ok';
    }

    public function newMessageReceived($data, $group_id)
    {
        $this->dispatch(new NewMessageReceived($data, $group_id));
    }

    public function setAllow($id, $group_id)
    {
        try {
            Clients::where(['vk_id' => $id, 'group_id' => $group_id])->update(['can_send' => 1]);
        } catch (\Exception $ex) {
            $err       = new Errors();
            $err->text = $ex->getMessage();
            $err->url  = $ex->getLine();
            $err->save();
        }
    }

    public function setDeny($id, $group_id)
    {
        try {
            Clients::where(['vk_id' => $id, 'group_id' => $group_id])->update(['can_send' => 0]);
        } catch (\Exception $ex) {
            $err       = new Errors();
            $err->text = $ex->getMessage();
            $err->url  = $ex->getLine();
            $err->save();
        }
    }
}
