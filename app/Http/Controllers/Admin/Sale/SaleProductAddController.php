<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Services\SaleService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SaleProductAddController extends Controller
{
    use ApiResponse;

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $product = SaleService::productAdd($request->get('product_barcode'));
        if (!isset($product)) {
            $validator = Validator::make([], []);
            $validator->errors()->add('product_sku', 'Product not found');
            throw new ValidationException($validator);
        }
        return $this->respondSuccess($product, 'Product add successfully');
    }
}
