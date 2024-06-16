<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NewSellRequest extends FormRequest
{
    public function rules(Request $request): array
    {
//        dd($request->all());
        return [
//            'invoice_code' => 'required|unique:sales,invoice_code',
            'customer.phone' => 'required',
            'customer.name' => 'required',
            'customer.address' => 'required',
            'seller_id' => 'required',
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
            'sale_products.*.available_stock' => 'required|numeric|min:1',
            'sale_products.*.quantity' => 'required|numeric|min:1',
            'sale_payments.*.payment_method.value' => 'required',
            'sale_payments.*.pay_amount' => 'required|numeric|min:1',
            'sale_payments.*.payment_reference' => [
                'required_if:sale_payments.*.payment_method.reference_status,1',
            ],
            'pathao_info.store.store_id' => "required_if:delivery_man.name,Pathao",
            'pathao_info.recipient_name' => "required_if:delivery_man.name,Pathao",
            'pathao_info.recipient_phone' => "required_if:delivery_man.name,Pathao",
            'pathao_info.recipient_address' => "required_if:delivery_man.name,Pathao",
            'pathao_info.recipient_city.city_id' => "required_if:delivery_man.name,Pathao",
            'pathao_info.recipient_zone.zone_id' => "required_if:delivery_man.name,Pathao",
            // 'pathao_info.recipient_area.area_id' => "required_if:delivery_man.name,Pathao",
            'pathao_info.delivery_type' => "required_if:delivery_man.name,Pathao",
            'pathao_info.item_type' => "required_if:delivery_man.name,Pathao",
            'pathao_info.item_quantity' => "required_if:delivery_man.name,Pathao",
            'pathao_info.item_weight' => "required_if:delivery_man.name,Pathao",
            'pathao_info.amount_to_collect' => "required_if:delivery_man.name,Pathao|numeric|min:0",
            'pathao_info.pricePlan' => "required_if:delivery_man.name,Pathao",

            'winx_info.delivery_area.value' => "required_if:delivery_man.name,Winx",
            'winx_info.store.value' => "required_if:delivery_man.name,Winx",
            'winx_info.package' => "required_if:delivery_man.name,Winx",
            'winx_info.recipient_name' => "required_if:delivery_man.name,Winx",
            'winx_info.recipient_phone' => "required_if:delivery_man.name,Winx",
            'winx_info.recipient_address' => "required_if:delivery_man.name,Winx",
        ];
    }

    public function messages(): array
    {
        return [
            'customer.phone.required' => "Customer phone required",
            'customer.name.required' => "Customer name required",
            'customer.address.required' => "Customer address required",
            'sale_payments.*.payment_method.value.required' => "Select a payment method",
            'sale_payments.*.pay_amount.min' => "Pay amount required",
            'sale_payments.*.pay_amount.required' => "Pay amount required",
            'sale_products.required' => "Product required",
            'sale_products.*.available_stock.min' => 'Product Stock Out',
            'sale_payments.*.payment_reference.required_if' => 'Payment reference required',
            'pathao_info.store.store_id.required_if' => 'Store required when delivery is :value',
            'pathao_info.recipient_name.required_if' => 'Recipient name required when delivery is :value',
            'pathao_info.recipient_phone.required_if' => 'Recipient phone required when delivery is :value',
            'pathao_info.recipient_address.required_if' => 'Recipient address required when delivery is :value',
            'pathao_info.recipient_city.city_id.required_if' => 'City required when delivery is :value',
            'pathao_info.recipient_zone.zone_id.required_if' => 'Zone required when delivery is :value',
            // 'pathao_info.recipient_area.area_id.required_if' => 'Area required when delivery is :value',
            'pathao_info.delivery_type.required_if' => 'Delivery type required when delivery is :value',
            'pathao_info.item_type.required_if' => 'Item type  required when delivery is :value',
            'pathao_info.item_quantity.required_if' => 'Item quantity required when delivery is :value',
            'pathao_info.item_weight.required_if' => 'Item weight required when delivery is :value',
            'pathao_info.amount_to_collect.required_if' => 'Amount to collect required when delivery is :value',
            'pathao_info.pricePlan.required_if' => 'Delivery charge required when delivery is :value',
            'due_total.required' => "Sale due amount must be 0",
            'delivery_man.required_if' => "The delivery man required when delivery option is true",

            'winx_info.delivery_area.value.required_if' => 'Delivery area required when delivery is :value',
            'winx_info.store.value.required_if' => 'Store required when delivery is :value',
            'winx_info.package.required_if' => 'Package required when delivery is :value',
            'winx_info.recipient_name.required_if' => 'Recipient name required when delivery is :value',
            'winx_info.recipient_phone.required_if' => 'Recipient phone required when delivery is :value',
            'winx_info.recipient_address.required_if' => 'Recipient address required when delivery is :value',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
