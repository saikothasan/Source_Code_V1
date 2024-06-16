<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|numeric',
            'name' => 'required|string',
            'product_slug' => 'nullable',
            'brand_id' => 'required',
            'supplier_id' => 'required',
            'category_id' => 'required',
            'product_options' => 'nullable|boolean',
            'product_margin' => 'nullable',
            'product_profit' => 'nullable',
            'buy_price' => 'required|numeric',
            'sell_price' => 'required|numeric|gt:buy_price',
            'product_code' => 'required|max:8|unique:products,product_code,' . $this->route('product'),
            'product_sku' => 'required|max:10|unique:products,product_sku,' . $this->route('product'),
            'options.*.optionName' => 'required_if:product_options,true',
            'options.*.optionValues' => 'required_if:product_options,true',
            'variation_values' => 'required_if:product_options,true|array',
            'variation_values.*.variation_barcode' => 'required_if:product_options,true|max:8||unique:product_variant_sku_barcodes,variant_barcode,' . $this->route('product') . ',product_id',
            'variation_values.*.variation_sku' => 'required_if:product_options,true|max:10||unique:product_variant_sku_barcodes,variant_sku,' . $this->route('product') . ',product_id',
            'variation_values.*.variation_price' => [
                'required_if:product_options,true|numeric',
                'required_if:product_options,true|numeric|gt:variation_values.*.variant_buy_price'
            ],
            'variation_values.*.variant_buy_price' => 'required_if:product_options,true|numeric',
            'variation_values.*.variationValues' => 'required_if:product_options,true|array',
            'variation_values.*.variation_values_names' => 'required_if:product_options,true',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required',
            'supplier_id.required' => 'Supplier is required',
            'category_id.required' => 'Category is required',
            'brand_id.required' => 'Brand is required',
            'sell_price.gt' => 'Sell Price must greeter than buy price',
            'product_sku.required' => 'SKU is required',
            'product_sku.unique' => 'SKU already been taken',
            'product_code.required' => 'Barcode is required',
            'product_code.unique' => 'Barcode already been taken',
            'variation_values.*.variation_barcode.max' => 'Barcode may not be greater than 8 characters',
            'variation_values.*.variation_sku.max' => 'SKU may not be greater than 8 characters',
            'variation_values.*.variation_barcode.unique' => 'Barcode already been taken',
            'variation_values.*.variation_sku.unique' => 'SKU already been taken',
            'variation_values.*.variation_barcode.required_if' => 'Barcode is required',
            'variation_values.*.variation_price.required_if' => 'Sell Price is required',
            'variation_values.*.variation_price.gt' => 'Sell Price must greeter than buy price',
            'variation_values.*.variant_buy_price.required_if' => 'Buy Price is required',
            'variation_values.*.variation_sku.required_if' => 'Sku is required',
            'options.*.optionName.required_if' => 'Option name is required',
            'options.*.optionValues.required_if' => 'Option values is required',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
