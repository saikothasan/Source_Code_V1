<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class PathaoService
{
    public static $headers = [];

    public static function generateToken(): string
    {
        try {
            $accessToken = self::pathaoAuthorize();
            $accessToken = $accessToken->token_type . ' ' . $accessToken->access_token;
            return $accessToken;
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public static function getToken()
    {
        $existance = Storage::disk('local')->exists('pathao_token.json');
        if ($existance) {
            $bearerToken = Storage::get('pathao_token.json');
            $bearerToken = json_decode($bearerToken);
            $bearerToken = $bearerToken[0];
            return ['Authorization' => $bearerToken];
        } else {
            $pathaoAuthorize = self::pathaoAuthorize();
            $accessToken = [$pathaoAuthorize->token_type . ' ' . $pathaoAuthorize->access_token];
            Storage::disk('local')->put('pathao_token.json', json_encode($accessToken));
            return ['Authorization' => $accessToken];
        }
    }

    public static function pathaoAuthorize()
    {
        $params = [
            'client_id' => config('pathao.client_id'),
            'client_secret' => config('pathao.client_secret'),
            'username' => config('pathao.username'),
            'password' => config('pathao.password'),
            'grant_type' => config('pathao.grant_type'),
        ];
        try {
            $url = config('pathao.base_url') . 'issue-token';
            $response = Http::accept('application/json')->retry(2, 100)
                ->post($url, $params);
            return json_decode($response->body());
        } catch (\Exception $e) {
            return $e->getMessage();
        }

    }

    public static function post($endpoint, $params)
    {
        $url = config('pathao.base_url') . $endpoint;
        $response = Http::accept('application/json')->retry(2, 100)->withHeaders(self::getToken())
            ->post($url, $params);
        return json_decode($response->body());
    }

    public static function put($endpoint)
    {
        $url = config('pathao.base_url') . $endpoint;
        $response = Http::accept('application/json')->retry(2, 100)->withHeaders(self::getToken())
            ->put($url);
        return json_decode($response->body());
    }



    public static function get($endpoint)
    {
        $url = config('pathao.base_url') . $endpoint;
        $response = Http::accept('application/json')->retry(2, 100)->withHeaders(self::getToken())
            ->get($url);
        return json_decode($response->body());
    }
}
