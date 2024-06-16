<?php

namespace App\Http\Controllers\Admin\Sale\Winx;

use App\Http\Controllers\Controller;
use App\Services\PathaoService;
use App\Services\WinxService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class WinxController extends Controller
{
    use ApiResponse;

    public function getLocationList(): \Illuminate\Http\JsonResponse|string
    {
        try {
            $locations = WinxService::get('/api/location/select?full=yes');
            $locations = collect($locations->results)->map(function ($data) {
                return [
                    'value' => $data->id,
                    'hub_id' => $data->hub_id,
                    'inside_city' => $data->inside_city,
                    'sub_city' => $data->sub_city,
                    'inter_district' => $data->inter_district,
                    'division' => $data->division,
                    'district' => $data->district,
                    'thana' => $data->thana,
                    'suboffice' => $data->suboffice,
                    'postcode' => $data->postcode,
                    'status' => $data->status,
                    'text' => $data->text,
                ];
            });
            return $this->respondSuccess($locations, 'Locations successfully fetched.');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }


    public function getPackageList(): \Illuminate\Http\JsonResponse|string
    {
        try {
            $packages = WinxService::get('/api/package/select');
            $packages = collect($packages->results)->map(function ($data) {
                return [
                    'value' => $data->id,
                    'text' => $data->text,
                    'inside_city' =>$data->inside_city,
                    'inside_city_cod' =>$data->inside_city_cod,
                    'sub_city' =>$data->sub_city,
                    'sub_city_cod' =>$data->sub_city_cod,
                    'inter_district' =>$data->inter_district,
                    'inter_district_cod' =>$data->inter_district_cod,
                    'insurance' =>$data->insurance,
                ];
            });
            return $this->respondSuccess($packages, 'Packages successfully fetched.');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }


    public function getPickUpLocation(): \Illuminate\Http\JsonResponse|string
    {
        try {
            $pickUpLocation = WinxService::get('/api/pickup/select');
            $pickUpLocation = collect($pickUpLocation->results)->map(function ($data) {
                return [
                    'value' => $data->id,
                    'text' => $data->text,
                    'mobile' =>$data->mobile,
                ];
            });
            return $this->respondSuccess($pickUpLocation, 'Pickup locations successfully fetched.');
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
