<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Model\Customer;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SaleCustomerSearchController extends Controller
{

    use ApiResponse;

    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        try {
            $customerPhone = $request->customer_phone;
            $customer = Customer::query()->filterByPhone($customerPhone)
                ->first();
            if (!isset($customer)) {
                return $this->respondSuccess(null,'New Customer');
            }
            return $this->respondSuccess($customer, 'Customer add successfully');
        } catch (\Throwable $exception) {
            return $this->respondError('Something went wrong');
        }
    }
}
