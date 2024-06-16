<?php

namespace App\Http\Controllers\Admin\TransferReceived;

use App\Http\Controllers\Controller;
use App\Services\TransferReceivedService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;


class TransferProductSearchController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request, $search)
    {
        $offer_id = $request->offer_id;
        $product = TransferReceivedService::productSearch($search, $offer_id);
        if (!count($product)) {
            $validator = Validator::make([], []);
            $validator->errors()->add('product_sku', 'Out of stock');
            throw new ValidationException($validator);
        }
        return $this->respondSuccess($product, 'Sku product fetch successfully');
    }
}
