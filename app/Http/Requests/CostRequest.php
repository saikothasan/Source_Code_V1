<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CostRequest extends FormRequest
{
    /**
     * @var mixed
     */

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
            'selectedCost' => 'required',
            'cost_branch_id' => 'required|present',
            'selectedCostCategory' => [
                'required_if:selectedCost,daily_cost',
                'required_if:selectedCost,monthly_cost'
            ],
            'amount' => 'required|min:0',
            //tiffin
//            'details.employee_name' => [
//            ],
            'details.tiffin_price' => [
                'required_if:selectedCostCategory,tiffin',
            ],
            'details.tiffin_qty' => [
                'required_if:selectedCostCategory,tiffin',
            ],
            //transport
            'details.transport_form' => [
                'required_if:selectedCostCategory,transport',
            ],
            'details.transport_to' => [
                'required_if:selectedCostCategory,transport',
            ],
            //accessories
            'details.note' => [
                'required_if:selectedCostCategory,accessories',
                'required_if:selectedCostCategory,office_rent',
                'required_if:selectedCost,one_time_cost',
            ],
            //electric bill
            'details.selected_month' => [
                'required_if:selectedCostCategory,electric_bill',
                'required_if:selectedCostCategory,office_rent',
            ],
            'details.transaction_id' => [
                'required_if:selectedCostCategory,electric_bill',
            ],
            'details.selected_payment_method' => [
                'required_if:selectedCostCategory,electric_bill',
            ],
//            'details.payer_person' => [
//                'required_if:selectedCostCategory,electric_bill',
//            ],
            //asset
            'details.asset_name' => [
                'required_if:selectedCostCategory,asset',
            ],
            'details.selected_asset_position' => [
                'required_if:selectedCostCategory,asset',
            ],
            'details.purchase_shop' => [
                'required_if:selectedCostCategory,asset',
            ],
            'details.purchase_phone' => [
                'required_if:selectedCostCategory,asset',
            ],
            'details.purchase_cost' => [
                'required_if:selectedCostCategory,asset',
            ],
            'details.purchase_transport_cost' => [
                'required_if:selectedCostCategory,asset',
            ],

            //onetime
            'details.selected_employee' => [
                'required_if:selectedCost,one_time_cost',
                'required_if:selectedCostCategory,tiffin',

            ],
            //nested validation
            'details.amount_receiver_name' => [
                'required_if:selectedCostCategory,transport',
                'required_if:selectedCostCategory,office_rent',
                'required_if:selectedCostCategory,accessories',
                'required_if:selectedCostCategory,electric_bill',
                'required_if:selectedCostCategory,asset',
            ],
            'details.amount_receiver_phone' => [
                'required_if:selectedCostCategory,transport',
                'required_if:selectedCostCategory,office_rent',
                'required_if:selectedCostCategory,accessories',
                'required_if:selectedCostCategory,electric_bill',
                'required_if:selectedCostCategory,asset',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'amount.required' => 'Amount is Required &  Minimum is 0',
            'selectedCost.required' => 'Cost type is required',
            'selectedCostCategory.required_if' => 'Cost Category is required when Cost type is Daily Cost or Monthly Cost',
            //tiffin error messages
            'details.employee_name.required_if' => 'Employee Name is required ',
            'details.tiffin_price.required_if' => 'Tiffin  Price  is required ',
            'details.tiffin_qty.required_if' => 'Tiffin Quantity  is required ',
            //transport error messages
            'details.transport_form.required_if' => 'Transport Form  is required ',
            'details.transport_to.required_if' => 'Transport To  is required ',
            //accessories
            'details.note.required_if' => 'Note  is required ',
            //electric bill
            'details.selected_month.required_if' => 'Month  is required ',
            'details.transaction_id.required_if' => 'Transaction ID is required ',
            'details.selected_payment_method.required_if' => 'Payment Method is required ',
            'details.payer_person.required_if' => 'Paying Person is required ',
            //asset
            'details.asset_name.required_if' => 'Asset Name is required ',
            'details.selected_asset_position.required_if' => 'Asset Position is required ',
            'details.purchase_shop.required_if' => 'Purchase Shop is required ',
            'details.purchase_cost.required_if' => 'Purchase Cost is required ',
            'details.purchase_transport_cost.required_if' => 'Transport Cost is required ',
            //onetime
            'details.selected_employee.required_if' => 'Employee is required ',
            //common validation
            'details.amount_receiver_name.required_if' => 'Receiver Name is required ',
            'details.amount_receiver_phone.required_if' => 'Receiver Phone is required ',
        ];
    }
}
