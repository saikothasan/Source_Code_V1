<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Bank;
use App\Model\CashDrawer;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GetBankController extends Controller
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
            if ($request->select_payment_method !== 1 ) {
                $data = Bank::query()
                    ->where('user_id', $request->selected_branch['user_id'])
                    ->get();
                return $this->respondCreated($data, 'Branch Bank account fetched');
            }
            return $this->respondCreated(null);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }

    }
}
