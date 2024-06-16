<?php

namespace App\Http\Controllers\Admin\Sale\Pathao;

use App\Http\Controllers\Controller;
use App\Http\Requests\PathaoPriceCalculationRequest;
use App\Services\PathaoService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class PathaoController extends Controller
{
    use ApiResponse;

    public function generateToken()
    {
        Storage::delete('pathao_token.json');
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
            $response = json_decode($response->body());

            $accessToken = [$response->token_type . ' ' . $response->access_token];
            Storage::disk('local')->put('pathao_token.json', json_encode($accessToken));
            return ['Authorization' => $accessToken];
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getStoreList()
    {
        try {
            $cities = PathaoService::get('stores');
            $cities = collect($cities->data->data)->map(function ($data) {
                return [
                    'store_id' => $data->store_id,
                    'store_name' => $data->store_name,
                    'store_address' => $data->store_address,
                    'city_id' => $data->city_id,
                    'hub_id' => $data->hub_id,
                    'value' => $data->store_id,
                    'text' => $data->store_name,
                ];
            });
            return $this->respondSuccess($cities, 'City successfully fetched.');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function getCityList()
    {
        try {
            $cities = PathaoService::get('countries/1/city-list');
            $cities = collect($cities->data->data)->map(function ($data) {
                return [
                    'city_id' => $data->city_id,
                    'city_name' => $data->city_name,
                    'value' => $data->city_id,
                    'text' => $data->city_name,
                ];
            });
            return $this->respondSuccess($cities, 'City successfully fetched.');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function getCityZones($city)
    {
        try {
            $endpint = 'cities/' . $city . '/zone-list';
            $zones = PathaoService::get($endpint);

            $zones = collect($zones->data->data)->map(function ($data) {
                return [
                    'zone_id' => $data->zone_id,
                    'zone_name' => $data->zone_name,
                    'value' => $data->zone_id,
                    'text' => $data->zone_name,
                ];
            });
            return $this->respondSuccess($zones, 'Zone successfully fetched.');
        } catch (\Exception $exception) {

        }
    }

    public function getZoneArea($zone)
    {
        try {
            $endpint = 'zones/' . $zone . '/area-list';
            $zones = PathaoService::get($endpint);

            $zones = collect($zones->data->data)->map(function ($data) {
                return [
                    'area_id' => $data->area_id,
                    'area_name' => $data->area_name,
                    'home_delivery_available' => $data->home_delivery_available,
                    'pickup_available' => $data->pickup_available,
                    'value' => $data->area_id,
                    'text' => $data->area_name,
                ];
            });
            return $this->respondSuccess($zones, 'Zone successfully fetched.');
        } catch (\Exception $exception) {

        }
    }


    public function priceCalculation(PathaoPriceCalculationRequest $request)
    {
        try {
            $params = $request->all();
            $endpint = 'merchant/price-plan';
            return $this->respondSuccess(PathaoService::post($endpint, $params)->data, 'Zone successfully fetched.');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

}
