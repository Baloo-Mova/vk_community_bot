<?php
/**
 * Created by PhpStorm.
 * User: Мова
 * Date: 27.06.2017
 * Time: 15:30
 */

namespace App\Core;

use App\Models\BotCommunityResponse;
use App\Models\Errors;
use App\Models\UserGroups;
use App\Models\UserGroupsPivot;
use GuzzleHttp\Client;
use League\Flysystem\Exception;

class VK
{

    private $user;
    private $group;
    private $httpClient;

    private $groupScope = [
        'photo_100',
        'screen_name',
        'name',
        'id'
    ];

    private $authGroupScope = [
        'messages',
        'manage'
    ];

    public function __construct()
    {
        $this->httpClient = new Client([
            //  'proxy'  => '194.242.125.76:8000',
            'verify' => false,
        ]);
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function checkAccess()
    {
        $callBaaaaaack = env('APP_URL') . "/vk-tells-us/" . $this->group->group_id;
        $data          = $this->getCallbackServer();
        if (isset($data['error'])) {
            return false;
        }

        if (stripos($data['response']['server_url'], $callBaaaaaack) !== false) {
            return true;
        }

        return false;
    }

    public function getCallbackServer()
    {
        return $this->requestToApi('groups.getCallbackServerSettings', [
            'group_id' => $this->group->group_id
        ], true);
    }

    private function requestToApi($method, $fields, $asGroup = false)
    {
        if ( ! $asGroup) {
            $fields['access_token'] = $this->user->vk_token;
        } else {
            $fields['access_token'] = $this->group->token;
        }

        $fields['v'] = '5.64';

        $data = "";
        foreach ($fields as $key => $value) {
            $data .= $key . '=' . $value . '&';
        }
        $data = trim($data, '&');

        try {
            $response = $this->httpClient->post('https://api.vk.com/method/' . $method,
                ['form_params' => $fields])->getBody()->getContents();

            if (strpos($response, "error") !== false) {
                $error       = new Errors();
                $error->text = $response;
                $error->url  = $method . ' ' . $data;
                $error->save();

                return [];
            }

            return json_decode($response, true);
        } catch (\Exception $ex) {
            $error       = new Errors();
            $error->text = $ex->getMessage();
            $error->url  = $method . ' ' . $data;
            $error->save();
        }
    }

    public function getGroupKeyRequest($groupId)
    {
        return "https://oauth.vk.com/authorize?group_ids=" . $groupId . "&client_id=" . env('VKONTAKTE_KEY') . '&redirect_uri=' . env('VKONTAKTE_REDIRECT_GROUP_URI') . '&scope=' . implode(',',
                $this->authGroupScope) . '&response_type=code';
    }

    public function updateGroupAccessToken($code)
    {
        $params = [
            'client_id'     => env('VKONTAKTE_KEY'),
            'client_secret' => env('VKONTAKTE_SECRET'),
            'redirect_uri'  => env('VKONTAKTE_REDIRECT_GROUP_URI'),
            'code'          => $code
        ];
        $data   = $this->httpClient->get('https://oauth.vk.com/access_token?' . http_build_query($params))->getBody()->getContents();
        if (strpos($data, 'error') !== false) {
            return false;
        }

        $group_id  = 0;
        $result    = json_decode($data, true);
        $tokenName = "";
        foreach (array_keys($result) as $key) {
            if (strpos($key, 'access_token_') !== false) {
                $group_id  = str_replace('access_token_', '', $key);
                $tokenName = $key;
            }
        }

        if ($group_id == 0) {
            return false;
        }

        UserGroups::where('group_id', '=', $group_id)->update(['token' => $result[$tokenName]]);

        if ( ! $this->setCallbackServer($group_id)) {
            UserGroups::where('group_id', '=', $group_id)->update(['token' => null]);

            return false;
        }

        return true;
    }

    public function setCallbackServer($id)
    {
        $callBaaaaaack = env('APP_URL') . "/vk-tells-us/" . $id;
        $group         = UserGroups::whereGroupId($id)->first();
        if (isset($group) && isset($group->token)) {
            $this->setGroup($group);

            $data = $this->getCallbackServer();
            if (isset($data['error'])) {
                return false;
            }

            // Проверили все, надо ставить, собственно ставим...
            $data = $this->getCallbackCode($id);
            if (isset($data['error'])) {
                return false;
            }

            if (isset($data['response'])) {
                $code                    = $data['response']['code'];
                $group->success_response = $code;
                $group->save();
                $i = 10;
                while ($i) {
                    $data = $this->requestToApi('groups.setCallbackServer', [
                        'group_id'   => $id,
                        'server_url' => $callBaaaaaack
                    ], true);

                    if (isset($data['error'])) {
                        return false;
                    }

                    if ($data['response']['state_code'] == 1) {
                        break;
                    }
                    if ($data['response']['state_code'] == 3 || $data['response']['state_code'] == 4) {
                        return false;
                    }
                    sleep(2);
                    $i++;
                }

                $data = $this->requestToApi('groups.getCallbackServerSettings', [
                    'group_id' => $id
                ], true);
                if (isset($data['error'])) {
                    return false;
                }
                if ($data['response']['server_url'] != $callBaaaaaack) {
                    return false;
                }

                $this->group->secret_key = $data['response']['secret_key'];
                $this->group->save();
                $data = $this->requestToApi('groups.setCallbackSettings', [
                    'group_id'               => $id,
                    'message_new'            => 1,
                    'message_allow'          => 1,
                    'message_deny'           => 1,
                    'message_reply'          => 0,
                    'group_join'             => 0,
                    'group_leave'            => 1,
                    'photo_new'              => 0,
                    'audio_new'              => 0,
                    'video_new'              => 0,
                    'wall_reply_new'         => 0,
                    'wall_reply_edit'        => 0,
                    'wall_reply_delete'      => 0,
                    'wall_post_new'          => 0,
                    'wall_repost'            => 0,
                    'board_post_new'         => 0,
                    'board_post_edit'        => 0,
                    'board_post_delete'      => 0,
                    'board_post_restore'     => 0,
                    'photo_comment_new'      => 0,
                    'photo_comment_edit'     => 0,
                    'photo_comment_delete'   => 0,
                    'photo_comment_restore'  => 0,
                    'video_comment_new'      => 0,
                    'video_comment_edit'     => 0,
                    'video_comment_delete'   => 0,
                    'video_comment_restore'  => 0,
                    'market_comment_new'     => 0,
                    'market_comment_edit'    => 0,
                    'market_comment_delete'  => 0,
                    'market_comment_restore' => 0,
                    'poll_vote_new'          => 0,
                ], true);
                if ( ! isset($data['error'])) {
                    return true;
                }
            }
        }
    }

    public function setGroup($group)
    {
        $this->group = $group;
    }

    public function getCallbackCode($id)
    {
        return $this->requestToApi('groups.getCallbackConfirmationCode', [
            'group_id' => $id
        ], true);
    }

    public function canGroupSendMessage($id)
    {
        $data = $this->requestToApi('messages.isMessagesFromGroupAllowed', [
            'user_id'  => $id,
            'group_id' => $this->group->group_id
        ], true);

        if (isset($data['error'])) {
            return false;
        }

        if (isset($data['response'])) {
            return $data['response']['is_allowed'] == 1;
        }
    }

    public function updateUserGroups()
    {
        $adminGroups = $this->getAdminGroups();
        if ($adminGroups['response']['count'] > 1) {
            for ($i = 0; $i < $adminGroups['response']['count']; $i++) {
                $group     = $adminGroups['response']['items'][$i];
                $groupBase = UserGroups::where(['group_id' => $group['id']])->first();
                if ( ! isset($groupBase)) {
                    $groupBase = new UserGroups();
                }

                $groupBase->user_id  = 0;
                $groupBase->name     = $group['name'];
                $groupBase->avatar   = $group['photo_100'];
                $groupBase->group_id = $group['id'];
                $groupBase->save();

                $pivot = UserGroupsPivot::where([
                    'user_id'      => $this->user->id,
                    'usergroup_id' => $groupBase->id
                ])->first();
                if ( ! isset($pivot)) {
                    UserGroupsPivot::insert([
                        'user_id'      => $this->user->id,
                        'usergroup_id' => $groupBase->id
                    ]);
                }
            }
        }
    }

    public function getAdminGroups()
    {
        return $this->requestToApi('groups.get', [
            'extended' => 1,
            'filter'   => 'admin',
            'fields'   => implode(',', $this->groupScope),
        ], false);
    }

    public function getUserInfo($array)
    {
        return $this->requestToApi('users.get', [
            'user_ids' => implode(',', $array),
            'fields'   => 'photo_100'
        ])['response'];
    }

    public function massSend($message, $to)
    {
        return $this->requestToApi('messages.send', [
            'user_ids'  => implode(',', $to),
            'random_id' => intval(microtime(true) * 1000),
            'message'   => $message
        ], true);
    }

    public function getUnseenDialogs()
    {
        return $this->requestToApi('messages.getDialogs', [
            'count'  => 100,
            'unread' => 1,
        ], true)['response'];
    }

    public function setSeenMessage($messages, $userId)
    {
        return $this->requestToApi('messages.markAsRead', [
            'message_ids'      => implode(',', $messages),
            'peer_id'          => $userId,
            'start_message_id' => $messages[0]
        ], true);
    }

    public function sendMessage($message, $userId)
    {
        return $this->requestToApi('messages.send', [
            'user_id'   => $userId,
            'random_id' => intval(microtime(true) * 1000),
            'message'   => $message
        ], true);
    }

    private function log($message)
    {
        file_put_contents(storage_path('app/vklog.txt'), $message, 8);
    }

}