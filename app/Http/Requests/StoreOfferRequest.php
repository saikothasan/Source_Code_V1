<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'type' => 'required',
            'supplier_id' => [
                'required_if:type,2',
                'required_if:type,3',
                'required_if:type,4',
                'required_if:type,5',
            ],
            'title' => 'required',
//            'coupon_code' => 'required_if:type,2 | unique:offers,coupon_code|regex:/^[A-Z0-9]+$/i',
            'discount_percentage' => 'required_if:type,4',
//            'category_id' => 'required_if:type,4',
//            'brand_id' => 'required_if:type,4',
            'buy_quantity' => 'required_if:type,3',
            'get_quantity' => 'required_if:type,3',
            'combo_product' => 'required_if:type,5',
            'combo_code' => 'required_if:type,5',
            'discount_type' => 'required_if:type,5',
            'discount_amount' => 'required_if:type,5',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'offerProducts' => 'required|array',
            'offerProducts.*.product_discount_price' => [
                'exclude_if:type,3|required|numeric|gt:0',
                'exclude_if:type,5|required|numeric|gt:0',
            ],
            'status' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'Select a offer',
            'supplier_id.required_if' => 'Select a supplier',
            'title.required' => 'Title is required',
            'coupon_code.required_if' => 'Coupon code is required',
            'coupon_code.unique' => 'Coupon code already exists',
            'coupon_code.regex' => 'Coupon code must be capital letter and number',
            'discount_percentage.required_if' => 'Discount percentage is required',
            'category_id.required_if' => 'Select a category',
            'brand_id.required_if' => 'Select a brand',
            'buy_quantity.required_if' => 'Buy quantity is required',
            'get_quantity.required_if' => 'Get quantity is required',
            'combo_product.required_if' => 'Select a product',
            'combo_code.required_if' => 'Combo code is required',
            'discount_type.required_if' => 'Select a discount type',
            'discount_amount.required_if' => 'Discount amount is required',
            'start_date.required' => 'Start date is required',
            'start_date.date' => 'Start date must be a date',
            'end_date.required' => 'End date is required',
            'end_date.date' => 'End date must be a date',
            'end_date.after' => 'End date must be after start date',
            'offerProducts.required' => 'Select a product',
            'offerProducts.array' => 'Select a product',
            'offerProducts.*.product_discount_price.required' => 'Discount price is required',
            'offerProducts.*.product_discount_price.numeric' => 'Discount price must be a number',
            'offerProducts.*.product_discount_price.gt' => 'Discount price must be greater than 0',
            'status.required' => 'Select a status',
        ];
    }
}
