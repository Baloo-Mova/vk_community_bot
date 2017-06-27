<?php
/**
 * Created by PhpStorm.
 * User: Мова
 * Date: 27.06.2017
 * Time: 15:30
 */

namespace App\Core;

use GuzzleHttp\Client;

class VK
{

    private $user;
    private $httpClient;

    public function __construct($user)
    {
        $this->user = $user;
        $this->httpClient = new Client([
            'proxy'  => '185.148.24.243:8000',
            'verify' => false,
        ]);
    }


    public function getAdminGroups(){

        $response = $this->httpClient->get('https://api.vk.com/method/groups.get?filter=admin&access_token='.$this->user->vk_token);
        $data = $response->getBody()->getContents();

        return json_decode($data,true)['response'];
    }

    public function getGroupKeyRequest($groupId){



    }


}