<?php
/**
 * Created by PhpStorm.
 * User: Мова
 * Date: 27.06.2017
 * Time: 15:30
 */

namespace App\Core;

use App\Models\Errors;
use App\Models\UserGroups;
use GuzzleHttp\Client;
use League\Flysystem\Exception;

class VK
{

    private $user;
    private $httpClient;

    private $groupScope = [
        'photo_100',
        'screen_name',
        'name',
        'id'
    ];

    public function __construct($user)
    {
        $this->user       = $user;
        $this->httpClient = new Client([
            'proxy'  => '185.148.24.243:8000',
            'verify' => false,
        ]);
    }

    public function getGroupKeyRequest($groupId)
    {
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
        ]);
    }

    private function requestToApi($method, $fields)
    {
        $fields['access_token'] = $this->user->vk_token;
        $data                   = "";
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

}