<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpToDiscountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'type' => 'required',
            'supplier_id' => 'nullable',
            'title' => 'required',
            'slug' => 'required|',
            'invoice' => 'required',
            'start_date' => 'required|date:before:end_date',
            'end_date' => 'required|date|after:start_date',
            'share_discount' => 'nullable',
            'status' => 'required',
            'offerProducts' => 'required|array',
            'offerProducts.*.available_stock' => 'required|numeric|gt:0',
            'offerProducts.*.discount' => 'required|numeric|gt:0',
            'offerProducts.*.quantity' => 'required|numeric|gt:0 |lte:offerProducts.*.available_stock',
            'total_stock_quantity' => 'required|numeric|gt:0',
            'total_discount_quantity' => 'required|numeric|gt:0|lte:total_stock_quantity',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'Select a offer',
            'supplier_id' => 'Select a supplier',
            'title.required' => 'Title is Required',
            'slug.required' => 'Slug is Required',
            'invoice.required' => 'Invoice is Required',
            'start_date.required' => 'Start date is required',
            'end_date.required' => 'End date is required',
            'end_date.after' => 'End date must be after start date',
            'status.required' => 'Status is required',
            'offerProducts.required' => 'Products is required',
            'offerProducts.array' => 'Products are required',
            'offerProducts.*.available_stock.required' => 'Stock Quantity Must be greater than 0',
            'offerProducts.*.discount.required' => 'Enter a discount price',
            'offerProducts.*.discount.gt' => 'Discount must be greater than 0 ',
            'offerProducts.*.quantity.required' => 'Enter a quantity',
            'offerProducts.*.quantity.gt' => 'Quantity must be greater than 0',
            'offerProducts.*.quantity.lte' => 'Quantity must be less than or equal to available stock',
            'total_stock_quantity.required' => 'Total stock quantity is required',
            'total_discount_quantity.required' => 'Total discount quantity is required is ',
            'total_discount_quantity.gt' => 'Total discount quantity must be greater than 0',
            'total_discount_quantity.lte' => 'Total discount quantity must be less than or equal to total stock quantity',
        ];
    }
}
