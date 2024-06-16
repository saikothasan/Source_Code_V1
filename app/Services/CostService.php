<?php

namespace App\Services;

use App\Model\Branch;
use App\Model\Cost;
use App\Model\Employee;
use App\Model\PaymentMethod;
use Illuminate\Support\Facades\Auth;

class CostService
{
    public static function CostData(): array
    {
        return [
            'cost_resource' => json_encode([
                'all_cost_type' => [
                    'daily_cost' => 'Daily',
                    'monthly_cost' => 'Monthly',
                    'one_time_cost' => 'One Time',
                ],
                'cost_type' => [
                    'daily_cost' => [
                        'tiffin' => [
                            'selected_employee' => '',
                            'tiffin_price' => '',
                            'tiffin_qty' => '',
                        ],
                        'transport' => [
                            'transport_form' => '',
                            'transport_to' => '',
                            'amount_receiver_phone' => '',
                            'amount_receiver_name' => '',
                        ],
                        'accessories' => [
                            'note' => '',
                            'amount_receiver_phone' => '',
                            'amount_receiver_name' => '',
                        ],
                    ],
                    'monthly_cost' => [
                        'electric_bill' => [
                            'selected_month' => '',
                            'transaction_id' => '',
                            'selected_payment_method' => '',
//                            'payer_person' => '',
                            'amount_receiver_phone' => '',
                            'amount_receiver_name' => '',
                        ],
                        'water_bill' => [
                            'selected_month' => '',
                            'transaction_id' => '',
                            'selected_payment_method' => '',
//                            'payer_person' => '',
                            'amount_receiver_phone' => '',
                            'amount_receiver_name' => '',
                        ],
                        'service_charge' => [
                            'selected_month' => '',
                            'amount_receiver_phone' => '',
                            'amount_receiver_name' => '',
                            'note' => '',
                        ],
                        'office_rent' => [
                            'selected_month' => '',
                            'amount_receiver_phone' => '',
                            'amount_receiver_name' => '',
                            'note' => '',
                        ],
                        'asset' => [
                            'asset_name' => '',
                            'selected_asset_position' => '',
                            'purchase_shop' => '',
                            'purchase_phone' => '',
                            'purchase_cost' => '',
                            'purchase_transport_cost' => '',
//                            'purchase_amount_receiver'=> '',
                            'amount_receiver_phone' => '',
                            'amount_receiver_name' => '',
                        ],
                    ],
                    'one_time_cost' => [
                        'note' => '',
                        'selected_employee' => '',
                    ],
                ],
                'amount' => 0,
                'user' => auth()->user(),
                'allEmployee' => Employee::query()
                    ->select('id as value', 'name as text')
                    ->get()
                    ->toArray(),
                'assetPosition' => collect(getAllBranch())->toArray(),
                'paymentMethod' => PaymentMethod::query()
                    ->active()
                    ->select('id', 'name')
                    ->get()
                    ->toArray(),
                'allMonth' => getMonths(),
            ]),
            'cost_branch' => json_encode(collect(getAllBranch())->toArray()),

        ];
    }

    public static function costView(Cost $cost): array
    {
        return [
            'cost' => $cost->load([
                'creator:id,name,phone',
                'employee:id,name,phone',
                'paymentMethod:id,name',
                'assetBranch:id,name'
            ])
        ];
    }
}
