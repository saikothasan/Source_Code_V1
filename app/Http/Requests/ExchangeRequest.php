<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExchangeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'customer.phone' => 'required',
            'customer.name' => 'required',
            'customer.address' => 'required',
            'product_total' => 'required|numeric|min:0',
            'vat_amount' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'sale_net_total' => 'required|numeric|min:0',
            'total_discount' => 'required|numeric|min:0',
            'due_total' => 'required|numeric|max:0',
            'delivery_charge' => 'required|numeric|min:0',
            'additional_delivery_charge' => 'required|numeric|min:0',
            'additional_charge' => 'required|numeric|min:0',
            'delivery_man' => 'required_if:deliveryOption,true',
            'flat_discount' => 'required|numeric|min:0',
            'discount_percentage' => 'required|numeric|min:0',
            'vat_percentage' => 'required|numeric|min:0',
            'sale_products' => 'required|array',
            'return_products' => 'required|array',
            'sale_products.*.available_stock' => 'required|numeric|min:1',
            'sale_products.*.quantity' => 'required|numeric|min:1',
            'sale_payments.*.payment_method.value' => 'required_unless:payable_amount,0',
            'sale_payments.*.pay_amount' => 'required_unless:payable_amount,0',
            'sale_payments.*.payment_reference' => [
                'required_if:sale_payments.*.payment_method.reference_status,1',
            ],
            'pathao_info.store.store_id' => "required_if:delivery_man.name,Pathao",
            'pathao_info.recipient_name' => "required_if:delivery_man.name,Pathao",
            'pathao_info.recipient_phone' => "required_if:delivery_man.name,Pathao",
            'pathao_info.recipient_address' => "required_if:delivery_man.name,Pathao",
            'pathao_info.recipient_city.city_id' => "required_if:delivery_man.name,Pathao",
            'pathao_info.recipient_zone.zone_id' => "required_if:delivery_man.name,Pathao",
//            'pathao_info.recipient_area.area_id' => "required_if:delivery_man.name,Pathao",
            'pathao_info.delivery_type' => "required_if:delivery_man.name,Pathao",
            'pathao_info.item_type' => "required_if:delivery_man.name,Pathao",
            'pathao_info.item_quantity' => "required_if:delivery_man.name,Pathao",
            'pathao_info.item_weight' => "required_if:delivery_man.name,Pathao",
            'pathao_info.amount_to_collect' => "required_if:delivery_man.name,Pathao|numeric|min:0",
            'pathao_info.pricePlan' => "required_if:delivery_man.name,Pathao",
            'buy_more_product_amount' => 'required|numeric|max:0',
        ];
    }

    public function messages(): array
    {
        return [
            'customer.phone.required' => "Customer phone required",
            'customer.name.required' => "Customer name required",
            'customer.address.required' => "Customer address required",
            'sale_payments.*.payment_method.value.required_unless' => "Select a payment method",
            'sale_payments.*.payment_method.value.required' => "Select a payment method",
            'sale_payments.*.pay_amount.required_unless' => "Pay amount required",
            'sale_payments.*.pay_amount.min' => "Pay amount required",
            'sale_payments.*.pay_amount.required' => "Pay amount required",
            'sale_products.required' => "Product required",
            'return_products.required' => "Return product required",
            'sale_products.*.available_stock.min' => 'Product Stock Out',
            'sale_products.*.quantity.min' => 'Product quantity must be more than 0',
            'sale_payments.*.payment_reference.required_if' => 'Payment reference required',
            'pathao_info.store.store_id.required_if' => 'Store required when delivery is :value',
            'pathao_info.recipient_name.required_if' => 'Recipient name required when delivery is :value',
            'pathao_info.recipient_phone.required_if' => 'Recipient phone required when delivery is :value',
            'pathao_info.recipient_address.required_if' => 'Recipient address required when delivery is :value',
            'pathao_info.recipient_city.city_id.required_if' => 'City required when delivery is :value',
            'pathao_info.recipient_zone.zone_id.required_if' => 'Zone required when delivery is :value',
            'pathao_info.recipient_area.area_id.required_if' => 'Area required when delivery is :value',
            'pathao_info.delivery_type.required_if' => 'Delivery type required when delivery is :value',
            'pathao_info.item_type.required_if' => 'Item type  required when delivery is :value',
            'pathao_info.item_quantity.required_if' => 'Item quantity required when delivery is :value',
            'pathao_info.item_weight.required_if' => 'Item weight required when delivery is :value',
            'pathao_info.amount_to_collect.required_if' => 'Amount to collect required when delivery is :value',
            'pathao_info.pricePlan.required_if' => 'Delivery charge required when delivery is :value',
            'due_total.required' => "Sale due amount must be 0",
            'delivery_man.required_if' => "The delivery man required when delivery option is true",
            'buy_more_product_amount.max' => "Please add more new product "
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
