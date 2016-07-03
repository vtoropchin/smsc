<?php

namespace CoderStudio\Smsc;

use Illuminate\Database\Eloquent\Model;

class Smsc extends Model
{
    public function sendSMS($phone, $text)
    {
        file_get_contents("http://smsc.ru/sys/send.php?login=$login&psw=$password&phones=$phone&mes=$text&charset=utf-8");

        $json = file_get_contents('http://smsc.ru/sys/send.php', false, stream_context_create(array(
            'http' => array(
                'method'  => 'GET',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query(
                    [
                        'login' => urlencode(config('smsc.login')),
                        'psw' => urlencode(config('smsc.password')),
                        'phones' => urlencode(preg_replace('/[^0-9]/', null, $phone)),
                        'mes' => urlencode($text),
                        'charset' => 'utf-8',
                    ]
                )
            )
        )));

        return $json;
    }
}
