<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSkuRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'product_sku' => 'required_with:exists:products,product_sku|required_with:exists:product_variant_sku_barcodes,variant_barcode',

        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function messages()
    {
        return [
            'product_sku.exists' => 'Product Sku Not Found'
        ];
    }
}
