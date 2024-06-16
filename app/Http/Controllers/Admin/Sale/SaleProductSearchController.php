<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Services\SaleService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SaleProductSearchController extends Controller
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
        $product = SaleService::productSearch($request->get('product_barcode'));
        if (!isset($product)) {
            $validator = Validator::make([], []);
            $validator->errors()->add('product_sku', 'Product not found');
            throw new ValidationException($validator);
        }
        return $this->respondSuccess($product, 'Product add successfully');
    }
}
