<?php

namespace App\Services;

class SMSService
{
    public static function sendSms($sms)
    {
        $to      = $sms['sms_to'];
        $token   = config('app.sms_token');
        $message = $sms['sms_text'];
        $url     = "https://api.greenweb.com.bd/api.php?json";
        $data    = array(
            'to'      => $to,
            'message' => $message,
            'token'   => $token,
        );
//        dd($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_ENCODING, '');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $smsResult = curl_exec($ch);
        //Result
        $resultData = collect(json_decode($smsResult))->first();
        return $resultData;
    }
}
