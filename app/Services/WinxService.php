<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WinxService
{
    public static $headers = [];


    public static function getToken(): array
    {
        $accessToken = config('winx.token');
        return ['Authorization' => 'Bearer ' . $accessToken];
    }

    public static function get($endpoint)
    {
        $url = config('winx.base_url') . $endpoint;
        $response = Http::accept('application/json')
            ->retry(2, 100)
            ->withHeaders(self::getToken())
            ->get($url);
        return json_decode($response->body());
    }


    public static function post($endpoint, $params)
    {
        $url = config('winx.base_url') . $endpoint;
        $response = Http::accept('application/json')
            ->withHeaders(self::getToken())
            ->post($url, $params);

        return json_decode($response->body());
    }


    public static function put($endpoint)
    {
        $url = config('winx.base_url') . $endpoint;
        $response = Http::accept('application/json')
            ->retry(2, 100)
            ->withHeaders(self::getToken())
            ->put($url);
        return json_decode($response->body());
    }
}
