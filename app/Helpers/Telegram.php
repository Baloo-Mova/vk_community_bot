<?php

namespace App\Helpers;

use App\Models\Errors;
use GuzzleHttp\Client;
use App\Models\UserGroups;
use Illuminate\Support\Facades\Storage;

class Telegram
{
    public $arguments;
    public $client;
    public $chat_id;
    public $bot;

    public function __construct()
    {
        $this->client = new Client([
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36 OPR/41.0.2353.69',
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate, lzma, sdch, br',
                'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.6,en;q=0.4',
            ],
            'verify' => false,
            'cookies' => true,
            'allow_redirects' => true,
            'timeout' => 15
        ]);
    }

    public function sendMessage($chatId, $text)
    {
        if (!isset($chatId) || !isset($text)) {
            return false;
        }

        $telegram_token = config('telegram.token');

        if (!isset($telegram_token)) {
            return false;
        }
        try {
            $request = $this->client->request("GET",
                "https://api.telegram.org/bot" . $telegram_token . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($text));

            if ($request) {
                return true;
            }
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function getUpdates()
    {
        try {
            if (!file_exists(storage_path('app/telegram.txt'))) {
                file_put_contents(storage_path('app/telegram.txt'), '0');
            }
            $url = "https://api.telegram.org/bot" . config('telegram.token') . "/getUpdates?offset=" . file_get_contents(storage_path('app/telegram.txt'));

            $request = $this->client->request("GET", $url);
            $data = json_decode($request->getBody()->getContents());

            if (!empty($data) && $data->ok) {
                $results = $data->result;
            } else {
                $results = [];
            }

            if (count($results) > 0) {
                $users = [];
                foreach ($results as $item) {
                    file_put_contents(storage_path('app/telegram.txt'), $item->update_id + 1);
                    $group = UserGroups::where(['telegram_keyword' => trim($item->message->text)])->first();
                    if (!isset($group)) {
                        $this->sendMessage($item->message->chat->id, "Не понял вопроса...");
                        continue;
                    }

                    $group->telegram = $item->message->chat->id;
                    $group->save();

                    $this->sendMessage($item->message->chat->id, "Вы успешно привязали Telegram к группе: \"" . $group->name . "\"");
                }
            }
        } catch (\Exception $ex) {
            $err = new Errors();
            $err->text = $ex->getMessage() . " " . $ex->getLine();
            $err->url = "telegram:updates";
            $err->save();
        }
    }
}