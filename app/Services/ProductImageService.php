<?php

namespace App\Services;

use App\Model\Variation;

class ProductImageService
{
    public static function productImageResource($product)
    {
        $product->load([
            'options.optionName:id,variation_name',
            'options.optionValues.variantValueName:id,variation_value,variation_code,type_id',
            'options.optionValues' => function ($query) {
                $query->groupBy('variant_value', 'option_id');
            },
            'productVariantSkuBarcode.variantValues.variantValueName:id,variation_value,variation_code,type_id'
        ]);
        $productOptions = [];
        $variationValues = [];
        if ($product->product_options) {
            $optionsId = collect($product->options)->pluck('option_id')->toArray();
            $variantValues = Variation::query()->whereNull('variation_name')->whereIn('type_id', $optionsId)->get();
            $productOptions = $product->options->map(function ($option) use ($variantValues) {
                $optionValues = collect($option['optionValues'])->where('option_id', $option['option_id']);
                $variantValues = collect($variantValues)->where('type_id', $option['option_id'])->toArray();
                return [
                    'optionName' => self::getOptionName($variantValues, $option),
                    'optionValues' => self::getOptionValues($optionValues, $option),
                ];
            });
            $productOptions = collect($productOptions)->where('optionName.text' , '!=', 'Size')->collapse()->toArray();
            $variationValues = $product->productVariantSkuBarcode->map(function ($variant_sku_barcode) {
                $variantValueNames = collect($variant_sku_barcode['variantValues'])
                    ->where('product_variant_sku_id', $variant_sku_barcode['id'])
                    ->pluck('variantValueName.variation_value')->toArray();
                return [
                    'variation_barcode' => $variant_sku_barcode['variant_barcode'],
                    'variation_price' => $variant_sku_barcode['variant_price'],
                    'variant_buy_price' => $variant_sku_barcode['variant_buy_price'],
                    'variation_sku' => $variant_sku_barcode['variant_sku'],
                    'variation_values_names' => collect($variantValueNames)->implode('-'),
                    'variationValues' => $variantValueNames,
                ];
            })->toArray();
        }

        $productInfo = [
            'id' => $product->id,
            'name' => $product->name,
            'product_slug' => $product->product_slug,
            'product_sku' => $product->product_sku,
            'brand_id' => $product->brand_id,
            'supplier_id' => $product->supplier_id,
            'product_options' => $product->product_options,
            'product_code' => $product->product_code,
            'category_id' => $product->category_id,
            'description' => $product->description,
            'buy_price' => $product->buy_price,
            'product_margin' => $product->product_margin,
            'product_profit' => $product->product_profit,
            'is_draft' => $product->is_draft,
            'is_active' => $product->is_active,
            'sell_price' => $product->sell_price,
            'total_stock' => $product->total_stock,
        ];
        return [
            'product' => $productInfo,
            'productOptions' => $productOptions,
            'productOptionsValues' => $variationValues,
        ];
    }

    protected static function getOptionValues($optionValues, $option): array
    {
        $optionValues = [$optionValues->map(function ($data) use ($option) {
            if ($data->option_id == $option['option_id']) {
                return [
                    'value' => $data->variant_value,
                    'text' => $data['variantValueName']['variation_value'],
                    'variation_code' => $data['variantValueName']['variation_code'],
                    'type_id' => $data->option_id,
                ];
            }
        })];
        return collect($optionValues)->collapse()->toArray();
    }

    protected static function getOptionName($variantValues, $option)
    {
        $variantValues = [collect($variantValues)->map(function ($value) {
            return [
                'text' => $value['variation_value'],
                'type_id' => $value['type_id'],
                'value' => $value['id'],
                'variation_code' => $value['variation_code'],
            ];
        })];
        return [
            'text' => $option['optionName']['variation_name'],
            'value' => $option['option_id'],
            'variation_value' => collect($variantValues)->collapse()->toArray(),
        ];
    }
}
