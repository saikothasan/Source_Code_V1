<?php

namespace App\Actions;

use App\Http\Requests\ProductRequest;
use App\Model\Product;
use App\Model\ProductOption;
use App\Model\ProductVariantSkuBarcode;
use App\Model\ProductVariantValues;
use App\Model\Variation;

class ProductStoreAction
{

    public function handle($request, Product $product): Product
    {

        $data = $request->validated();
        $product->fill($data)->save();
        if ($data['product_options'] && isset($data['options'])) {
            $options = [];
            foreach ($data['options'] as $value) {
                $options[] = [
                    'product_id' => $product->id,
                    'option_id' => $value['optionName']['value']
                ];
                if (isset($value['optionValues'])) {
                    $newVarients = [];
                    foreach ($value['optionValues'] as $variant_value) {
                        $prev = Variation::query()->whereNull('variation_name')
                            ->where('variation_value', $variant_value['text'])
                            ->first();
                        if (!$prev) {
                            $newVarients[] = [
                                'type_id' => $value['optionName']['value'],
                                'variation_value' => $variant_value['text'],
                            ];
                        }
                    }
                    if (isset($newVarients)) {
                        Variation::insert($newVarients);
                    }
                }
            }
            ProductOption::insert($options);
        }

        if ($data['product_options'] && isset($data['variation_values'])) {
            foreach ($data['variation_values'] as $value) {

                $variantSkuBarcode = [
                    'product_id' => $product->id,
                    'variant_price' => $value['variation_price'] ?? 0,
                    'variant_buy_price' => $value['variant_buy_price'] ?? 0,
                    'variant_sku' => $value['variation_sku'],
                    'variant_barcode' => $value['variation_barcode'],
                ];
                $productVariantSkuBarcode = ProductVariantSkuBarcode::create($variantSkuBarcode);
                $productVariantValues = [];
                foreach ($value['variationValues'] as $variation_values) {
                    $option_value = Variation::query()->whereNull('variation_name')
                        ->where('variation_value', $variation_values)
                        ->first();
                    $productVariantValues[] = [
                        'product_id' => $product->id,
                        'product_variant_sku_id' => $productVariantSkuBarcode->id,
                        'option_id' => $option_value->type_id,
                        'variant_value' => $option_value->id,
                    ];
                }
                ProductVariantValues::insert($productVariantValues);
            }
        }
        return $product;
    }

}
