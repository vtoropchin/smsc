<?php

namespace CoderStudio\Smsc;

use Illuminate\Database\Eloquent\Model;

class Smsc extends Model
{
    public function sendSMS($phone, $sender, $text)
    {
        $phones = explode(',', preg_replace('/[^0-9,]/', null, $phone));
        $json = file_get_contents('http://smsc.ru/sys/send.php', false, stream_context_create(array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query(
                    [
                        'login' => urlencode(config('smsc.login')),
                        'psw' => urlencode(config('smsc.password')),
                        'phones' => implode(',', $phones),
                        'mes' => $text,
                        'charset' => 'utf-8',
                        'fmt' => 3,
                        'sender' => urlencode($sender),
                        'tinyurl' => config('smsc.tinyurl'),
                    ]
                )
            )
        )));

        $jsonDecode = json_decode($json);
        dump($jsonDecode);
        if (isset($jsonDecode->cnt) and $jsonDecode->cnt > 0)
        {
            return true;
        }
        return false;
    }
}
