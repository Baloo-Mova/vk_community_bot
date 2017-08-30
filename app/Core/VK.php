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
            'proxy' => '194.28.210.3:8000',
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
        $data = $this->getCallbackServers();
        if (isset($data['error'])) {
            return false;
        }
        foreach ($data['response']['items'] as $item) {
            if ($item['url'] == $callBaaaaaack) {
                if ($item['status'] == 'ok') {
                    return true;
                }
            }
        }

        return false;
    }

    public function getCallbackServers()
    {
        return $this->requestToApi('groups.getCallbackServers', [
            'group_id' => $this->group->group_id
        ], true);
    }

    private function requestToApi($method, $fields, $asGroup = false)
    {
        if (!$asGroup) {
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
                $error = new Errors();
                $error->text = $response;
                $error->url = $method . ' ' . $data;
                $error->save();

                return [];
            }

            return json_decode($response, true);
        } catch (\Exception $ex) {
            $error = new Errors();
            $error->text = $ex->getMessage();
            $error->url = $method . ' ' . $data;
            $error->save();
        }

        return [];
    }

    public function getGroupKeyRequest($groupId)
    {
        return "https://oauth.vk.com/authorize?group_ids=" . $groupId . "&client_id=" . env('VKONTAKTE_KEY') . '&redirect_uri=' . env('VKONTAKTE_REDIRECT_GROUP_URI') . '&scope=' . implode(',',
                $this->authGroupScope) . '&response_type=code';
    }

    public function updateGroupAccessToken($code)
    {
        $params = [
            'client_id' => env('VKONTAKTE_KEY'),
            'client_secret' => env('VKONTAKTE_SECRET'),
            'redirect_uri' => env('VKONTAKTE_REDIRECT_GROUP_URI'),
            'code' => $code
        ];
        $data = $this->httpClient->get('https://oauth.vk.com/access_token?' . http_build_query($params))->getBody()->getContents();
        if (strpos($data, 'error') !== false) {

            return false;
        }

        $group_id = 0;
        $result = json_decode($data, true);
        $tokenName = "";
        foreach (array_keys($result) as $key) {
            if (strpos($key, 'access_token_') !== false) {
                $group_id = str_replace('access_token_', '', $key);
                $tokenName = $key;
            }
        }

        if ($group_id == 0) {

            return false;
        }

        UserGroups::where('group_id', '=', $group_id)->update(['token' => $result[$tokenName]]);

        if (!$this->setCallbackServer($group_id)) {
            UserGroups::where('group_id', '=', $group_id)->update(['token' => null]);

            return false;
        }

        return true;
    }

    public function addCallbackServer($groupId, $url)
    {
        return $this->requestToApi('groups.addCallbackServer', [
            'group_id' => $groupId,
            'url' => $url,
            'title' => 'VKKnocker',
        ], true);
    }

    public function setCallbackServer($id)
    {
        try {
            $callBaaaaaack = env('APP_URL') . "/vk-tells-us/" . $id;
            $group = UserGroups::whereGroupId($id)->first();
            if (isset($group) && isset($group->token)) {
                $this->setGroup($group);

                $data = $this->getCallbackServers();
                if (isset($data['error'])) {
                    return false;
                }
                $needSetOurServer = true;
                $failServers = [];
                foreach ($data['response']['items'] as $item) {
                    if ($item['url'] == $callBaaaaaack) {
                        if ($item['status'] == 'ok') {
                            $needSetOurServer = false;
                        } else {
                            $failServers [] = $item['id'];
                        }
                    }
                }

                if (!empty($failServers)) {
                    foreach ($failServers as $server_id) {
                        $this->requestToApi('groups.deleteCallbackServer', [
                            'group_id' => $group->group_id,
                            'server_id' => $server_id
                        ], true);
                    }
                }


                $data = $this->getCallbackCode($id);
                if (isset($data['error']) || empty($data)) {
                    return false;
                }

                $code = $data['response']['code'];
                $group->success_response = $code;
                $group->save();

                if ($needSetOurServer) {
                    //Устанавливаем сервер
                    $data = $this->addCallbackServer($id, $callBaaaaaack);
                    if (isset($data['error']) || empty($data)) {
                        return false;
                    }

                    $group->server_id = $data['response']['server_id'];
                    $group->save();
                    sleep(3);
                    //проверяем статус сервера после установки
                    $result = $this->requestToApi('groups.getCallbackServers', [
                        'group_id' => $group->group_id,
                        'server_id' => $group->server_id
                    ], true);

                    if (empty($result) || $result['response']['items'][0]['status'] != 'ok') {
                        return "Проблема с подтверждением сервера";
                    }
                }

                $data = $this->requestToApi('groups.setCallbackSettings', [
                    'group_id' => $group->group_id,
                    'server_id' => $group->server_id,
                    'message_new' => 1,
                    'message_allow' => 1,
                    'message_deny' => 1,
                    'message_reply' => 1,
                    'group_join' => 1,
                    'group_leave' => 1,
                    'photo_new' => 1,
                    'audio_new' => 1,
                    'video_new' => 1,
                    'wall_reply_new' => 1,
                    'wall_reply_edit' => 1,
                    'wall_reply_delete' => 1,
                    'wall_post_new' => 1,
                    'wall_repost' => 1,
                    'board_post_new' => 1,
                    'board_post_edit' => 1,
                    'board_post_delete' => 1,
                    'board_post_restore' => 1,
                    'photo_comment_new' => 1,
                    'photo_comment_edit' => 1,
                    'photo_comment_delete' => 1,
                    'photo_comment_restore' => 1,
                    'video_comment_new' => 1,
                    'video_comment_edit' => 1,
                    'video_comment_delete' => 1,
                    'video_comment_restore' => 1,
                    'market_comment_new' => 1,
                    'market_comment_edit' => 1,
                    'market_comment_delete' => 1,
                    'market_comment_restore' => 1,
                    'poll_vote_new' => 1,
                ], true);


                if (empty($data)) {
                    return false;
                }
                if (!isset($data['error'])) {
                    return true;
                }
                return false;
            }
        } catch (\Exception $ex) {
            echo $ex->getLine() . ' ' . $ex->getMessage();
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
            'user_id' => $id,
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
        $test = [];
        $adminGroups = $this->getAdminGroups();
        if ($adminGroups['response']['count'] > 0) {
            for ($i = 0; $i < $adminGroups['response']['count']; $i++) {
                $group = $adminGroups['response']['items'][$i];
                $groupBase = UserGroups::where(['group_id' => $group['id']])->first();
                if (!isset($groupBase)) {
                    $groupBase = new UserGroups();
                }

                $groupBase->user_id = 0;
                $groupBase->name = $group['name'];
                $groupBase->avatar = $group['photo_100'];
                $groupBase->group_id = $group['id'];
                $groupBase->save();

                $pivot = UserGroupsPivot::where([
                    'user_id' => $this->user->id,
                    'usergroup_id' => $groupBase->id
                ])->first();
                if (!isset($pivot)) {
                    UserGroupsPivot::insert([
                        'user_id' => $this->user->id,
                        'usergroup_id' => $groupBase->id
                    ]);
                }

                $test[] = $groupBase->id;
            }

            UserGroupsPivot::whereNotIn('usergroup_id', $test)->where(['user_id' => $this->user->id])->delete();
        }
    }

    public function getAdminGroups()
    {
        return $this->requestToApi('groups.get', [
            'extended' => 1,
            'filter' => 'admin',
            'fields' => implode(',', $this->groupScope),
        ], false);
    }

    public function getUserInfo($array)
    {
        return $this->requestToApi('users.get', [
            'user_ids' => implode(',', $array),
            'fields' => 'photo_100'
        ])['response'];
    }

    public function massSend($message, $to)
    {
        return $this->requestToApi('messages.send', [
            'user_ids' => implode(',', $to),
            'random_id' => intval(microtime(true) * 1000),
            'message' => $message
        ], true);
    }

    public function getUnseenDialogs()
    {
        return $this->requestToApi('messages.getDialogs', [
            'count' => 100,
            'unread' => 1,
        ], true)['response'];
    }

    public function setSeenMessage($messages, $userId)
    {
        return $this->requestToApi('messages.markAsRead', [
            'message_ids' => implode(',', $messages),
            'peer_id' => $userId,
            'start_message_id' => $messages[0]
        ], true);
    }

    public function sendMessage($message, $userId)
    {
        return $this->requestToApi('messages.send', [
            'user_id' => $userId,
            'random_id' => intval(microtime(true) * 1000),
            'message' => $message
        ], true);
    }

    private function log($message)
    {
        file_put_contents(storage_path('app/vklog.txt'), $message, 8);
    }

}