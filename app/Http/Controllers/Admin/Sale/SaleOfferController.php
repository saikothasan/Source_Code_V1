<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Model\Offer;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaleOfferController extends Controller
{
    use ApiResponse;

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $offers = Offer::query()
                ->where('type', $request->offer_type)
                ->where('status', Offer::STATUS['active'])
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->select(['id', 'title', 'type', 'start_date', 'end_date', 'status',])
                ->get();
            if ($offers->isEmpty()) {
                return $this->respondSuccess([], 'No offer found');
            }
            return $this->respondSuccess($offers, 'Offer fetched successfully');
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'success' => false,
                'data' => [],
            ], 400);
        }
    }
}
