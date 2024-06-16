<?php

namespace App\Http\Controllers\Admin\Sale;

use App\Http\Controllers\Controller;
use App\Services\Offer\OfferService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SaleOfferProductController extends Controller
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

        $search = $request->get('product_barcode');
        $offer = $request->get('offer');
        $offer_type = $request->get('offer_type');
        $combo_code = $request->get('combo_code');

        $product = OfferService::productAdd($search, $offer_type, $offer, $combo_code);
        if (! isset($product)) {
            $validator = Validator::make([], []);
            $validator->errors()->add('product_sku', 'Product not found');
            throw new ValidationException($validator);
        }
        return $this->respondSuccess($product, 'Product add successfully');
    }
}
