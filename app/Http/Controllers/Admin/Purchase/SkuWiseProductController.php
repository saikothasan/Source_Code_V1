<?php

namespace App\Http\Controllers\Admin\Purchase;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSkuRequest;
use App\Model\Product;
use App\Services\ProductService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SkuWiseProductController extends Controller
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
        $product_sku = $request->get('product_sku');
        $product = ProductService::skuProductForPurchase($product_sku);
        if (!isset($product)) {
            $validator = Validator::make([], []);
            $validator->errors()->add('product_sku', 'Product not found');
            throw new ValidationException($validator);
        }
        return $this->respondSuccess($product, 'Sku product fetch successfully');

    }
}
