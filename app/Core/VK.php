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
        'photos',
        'messages',
        'docs',
        'manage'
    ];

    public function __construct()
    {
        $this->httpClient = new Client([
            'proxy'  => '185.148.24.243:8000',
            'verify' => false,
        ]);
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function setGroup($group)
    {
        $this->group = $group;
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

        return true;
    }

    public function updateUserGroups()
    {
        $adminGroups = $this->getAdminGroups();
        if (count($adminGroups['response']) > 1) {
            for ($i = 1; $i < count($adminGroups['response']); $i++) {
                $group = $adminGroups['response'][$i];

                $groupBase = UserGroups::where(['group_id' => $group['gid'], 'user_id' => $this->user->id])->first();
                if ( ! isset($groupBase)) {
                    $groupBase = new UserGroups();
                }

                $groupBase->user_id  = $this->user->id;
                $groupBase->name     = $group['name'];
                $groupBase->avatar   = $group['photo_100'];
                $groupBase->group_id = $group['gid'];
                $groupBase->save();
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
            $response = $this->httpClient->get('https://api.vk.com/method/' . $method . '?' . $data)->getBody()->getContents();

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

    public function getUnseenDialogs()
    {
        return $this->requestToApi('messages.getDialogs', [
            'count'  => 100,
            'unread' => 1,
        ], true)['response'];
    }

    public function setSeenMessage($messages, $userId){
        return $this->requestToApi('messages.markAsRead',[
            'message_ids'=>implode(',',$messages),
            'peer_id' => $userId
        ],true);
    }

}