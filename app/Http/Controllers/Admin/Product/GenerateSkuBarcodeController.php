<?php

namespace App\Http\Controllers\Admin\Product;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\ProductVariantSkuBarcode;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GenerateSkuBarcodeController extends Controller
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
        try {
            $supplier = $request->get('supplier');
            $category = $request->get('category');

            $product = Product::query()
                ->where('supplier_id', $supplier['value'])
                ->where('category_id', $category['value']);
            $lastProductCount = $product->count();

            $data['sku'] = $this->generateSku($lastProductCount, $supplier, $category);
            $data['product_code'] = $this->generateBarcode();
            $data['generate_barcode'] = $data['product_code'];

            return $this->respondSuccess($data, 'Sku barcode generate successfully');
        } catch (\Throwable $exception) {
            return response()->json([
                'message' => $exception->getLine() . ' ' . $exception->getMessage(),
                'success' => false,
                'data' => []
            ], 400);
        }
    }

    private function generateBarcode(): string
    {
        $product = Product::query()->latest('product_code')->first();
        $variantSkuBarcode = ProductVariantSkuBarcode::query()->latest('variant_barcode')->first();
        $product_code = max($product->product_code?? 10000000, $variantSkuBarcode->variant_barcode ?? 00000000);
        $product_code = (int)$product_code + 1;

        return Str::limit($product_code, 8, '');
    }

    private function generateSku($lastProductCount, $supplier, $category): string
    {
        $supplierCategory = Str::upper(substr(str_replace(' ', '', $supplier['text']), 0, 2))
            . '-' .
            Str::upper(substr(str_replace(' ', '', $category['text']), 0, 2));

        $sku = $supplierCategory . '-' . Str::padLeft($lastProductCount + 1, 3, 0);

        $lastSku = Product::query()
            ->where('product_sku', 'LIKE', '%' . $supplierCategory . '%')
            ->latest('product_sku')
            ->first();

        if ($lastSku) {
            $sku = $supplierCategory
                . '-' . Str::padLeft((int)str_replace($supplierCategory . '-', '', $lastSku->product_sku) + 1, 3, 0);
        }

        return Str::limit($sku, 10, '');
    }
}
