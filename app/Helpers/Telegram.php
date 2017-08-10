<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use App\Models\UserGroups;

class Telegram
{
    public $arguments;
    public $client;
    public $chat_id;
    public $bot;

    public function __construct()
    {
        $this->client = new Client([
            'headers'         => [
                'User-Agent'      => 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36 OPR/41.0.2353.69',
                'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, lzma, sdch, br',
                'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
            ],
            'verify'          => false,
            'cookies'         => true,
            'allow_redirects' => true,
            'timeout'         => 15
        ]);
    }

    public function sendMessage($group_id, $text)
    {
        if ( ! isset($group_id) || ! isset($text)) {
            return false;
        }

        $group = UserGroups::find($group_id);

        if(!isset($group)){
            return false;
        }

        $chat_id = $group->telegram;
        $telegram_token = config('telegram.token');

        if(!isset($telegram_token)){
            return false;
        }

        if (isset($chat_id)) {
            try {
                $request = $this->client->request("GET",
                    "https://api.telegram.org/bot" . $telegram_token . "/sendMessage?chat_id=" . $chat_id->chat_id . "&text=" . urlencode($text));

                if ($request) {
                    return true;
                }
            } catch (\Exception $ex) {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getUpdates()
    {
        try {
            $request = $this->client->request("GET",
                "https://api.telegram.org/bot" . $this->bot->bot_key . "/getUpdates?offset=" . $this->bot->offset);
            $data    = json_decode($request->getBody()->getContents());

            if ( ! empty($data) && $data->ok) {
                $results = $data->result;
            } else {
                $results = [];
            }

            if (count($results) > 0) {
                $users = [];
                foreach ($results as $item) {

                    $group = UserGroups::where(['telegram_keyword' => $item->message->text])->first();

                    if(!isset($group)){
                        continue;
                    }

                    $group->telegram = $item->message->chat->id;
                    $group->save();

                    $this->client->request("GET",
                        "https://api.telegram.org/bot" . config('telegram.token') . "/sendMessage?chat_id=" . $item->message->chat->id . "&text=Вы успешно привязали Telegram. Ваш TelegramId - ".$item->message->chat->id);

                }
            }
        } catch (\Exception $ex) {
        }
    }
}