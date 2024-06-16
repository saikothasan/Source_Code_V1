<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GiftProductRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable|numeric',
            'name' => 'required|string',
            'type' => 'nullable|numeric',
            'product_slug' => 'nullable',
            'product_options' => 'nullable|boolean',
            'product_code' => 'required|max:15|unique:products,product_code,' . $this->route('gift_product'),
            'product_sku' => 'required|max:15|unique:products,product_sku,' . $this->route('gift_product'),
            'options.*.optionName' => 'required_if:product_options,true',
            'options.*.optionValues' => 'required_if:product_options,true',
            'variation_values' => 'required_if:product_options,true|array',
            'variation_values.*.variation_barcode' => 'required_if:product_options,true|max:15||unique:product_variant_sku_barcodes,variant_barcode,' . $this->route('gift_product') . ',product_id',
            'variation_values.*.variation_sku' => 'required_if:product_options,true|max:15||unique:product_variant_sku_barcodes,variant_sku,' . $this->route('gift_product') . ',product_id',
            'variation_values.*.variationValues' => 'required_if:product_options,true|array',
            'variation_values.*.variation_values_names' => 'required_if:product_options,true',

        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Product name is required',
            'product_sku.required' => 'SKU is required',
            'product_sku.unique' => 'SKU already been taken',
            'product_code.required' => 'Barcode is required',
            'product_code.unique' => 'Barcode already been taken',
            'variation_values.*.variation_barcode.max' => 'Barcode may not be greater than 8 characters',
            'variation_values.*.variation_sku.max' => 'SKU may not be greater than 8 characters',
            'variation_values.*.variation_barcode.unique' => 'Barcode already been taken',
            'variation_values.*.variation_sku.unique' => 'SKU already been taken',
            'variation_values.*.variation_barcode.required_if' => 'Barcode is required',
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
