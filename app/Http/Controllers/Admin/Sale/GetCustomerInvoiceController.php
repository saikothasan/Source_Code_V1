<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\Sale\InvoiceResource;
use App\Model\Sale;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GetCustomerInvoiceController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, $customer)
    {
        $sale = Sale::query()
            ->whereHas('customer', function ($query) use ($customer) {
                $query->where('phone', $customer);
            })
            ->with(['customer:id,name,phone'])
            ->withSum('saleProducts as total_quantity', 'quantity')
            ->latest()
            ->get();
        if (!count($sale)) {
            $validator = Validator::make([], []);
            $validator->errors()->add('customer', 'Customer not found');
            throw new ValidationException($validator);
        }
        return $this->respondSuccess($sale, 'customer sale list');
    }
}
