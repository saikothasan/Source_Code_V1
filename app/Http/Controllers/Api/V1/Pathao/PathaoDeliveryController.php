<?php

namespace App\Http\Controllers\Api\V1\Pathao;

use App\Http\Controllers\Controller;
use App\Services\PathaSaleDeliveryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PathaoDeliveryController extends Controller
{

    use ApiResponse;
    public function __invoke(Request $request)
    {
        try {
            DB::beginTransaction();
            $deliver = PathaSaleDeliveryService::statusUpdate($request);
            DB::commit();
            return $this->respondSuccess(null, $deliver['message']);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "No query results for ".$request->get('consignment_id'),
                'success' => false,
                'data' => []
            ], 400);
        }
    }
}
