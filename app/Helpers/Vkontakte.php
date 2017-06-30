<?php

namespace App\Helpers;
use GuzzleHttp\Client;


class Vkontakte
{

    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36 OPR/41.0.2353.69',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, lzma, sdch, br',
                'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
            ],
            'proxy'  => '185.148.24.243:8000',
            'verify' => false,
            'cookies' => true,
            'allow_redirects' => true,
            'timeout' => 15
        ]);
    }

    public function getAdminGroups($user_id, $vk_token)
    {
        try{
            $request = $this->client->request("GET",
                "https://api.vk.com/method/groups.get".
                "?user_id=".$user_id.
                "&filter=admin".
                "&access_token=".$vk_token.
                "&v=5.65");

            $data = json_decode($request->getBody()->getContents());

            if(!isset($data->error)){
                return $data->items;
            }else{
                return false;
            }
        }catch (\Exception $ex){
            return false;
        }

    }
}